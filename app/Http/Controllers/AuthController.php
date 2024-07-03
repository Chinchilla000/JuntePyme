<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserPreferencia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserInformacion;

class AuthController extends Controller
{

    public function inicio()
    {
        return view('inicio.index'); // Asume que tienes una vista 'inicio.blade.php' en la carpeta 'resources/views/inicio'
    }

     // Método para el perfil del usuario
     public function perfilUsuario()
     {
         // Asegurar que hay un usuario autenticado
         if (!Auth::check()) {
             // Redirigir a la ruta de login si el usuario no está autenticado
             return redirect()->route('login')->with('error', 'Por favor, inicie sesión para acceder a esta página.');
         }
     
         // Cargar el usuario autenticado
         $user = Auth::user();
     
         // Inicializar el array de preferencias por usuario
         $preferenciasPorUsuario = [];
     
         // Obtener usuarios y clientes según el rol del usuario autenticado
         if (in_array($user->role, ['admin', 'Vendedor', 'Bodeguero'])) {
             $usuarios = User::whereIn('role', ['admin', 'Vendedor', 'Bodeguero'])->paginate(2, ['*'], 'usuariosPage');
             $clientes = User::where('role', 'User')->paginate(7, ['*'], 'clientesPage');
         } else {
             $usuarios = User::where('created_by', $user->id)->paginate(3, ['*'], 'usuariosPage');
             $clientes = User::where('created_by', $user->id)->where('role', 'User')->paginate(1, ['*'], 'clientesPage');
         }
     
         foreach ($usuarios as $usuario) {
             $preferenciasPorUsuario[$usuario->id] = UserPreferencia::where('user_id', $usuario->id)
                 ->pluck('estado', 'opcion_nombre')
                 ->toArray();
         }
     
         // Cargar las preferencias del usuario autenticado
         $preferenciasUsuario = UserPreferencia::where('user_id', $user->id)
             ->pluck('estado', 'opcion_nombre')
             ->toArray();
     
         // Pasar los datos a la vista del perfil del usuario
         return view('inicio.perfilUsuario', [
             'user' => $user,
             'usuarios' => $usuarios,
             'clientes' => $clientes,
             'preferenciasPorUsuario' => $preferenciasPorUsuario,
             'preferenciasUsuario' => $preferenciasUsuario,
         ]);
     }


     //Funcion para la creacion de los usuarios
    public function crearUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8',
            'role' => 'required|string',
            'rut' => 'nullable|string|unique:user_informacion,rut',
            'telefono' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'confirmed' => 'La confirmación de :attribute no coincide.',
            'unique' => 'El :attribute ya está en uso.',
            'email' => 'El :attribute debe ser una dirección de correo válida.',
            'min' => 'El :attribute debe tener al menos :min caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $createdBy = null; // Por defecto, si no se establece, 'created_by' será null
        if ($data['role'] !== 'admin') {
            // Si el usuario no es de tipo empresa, establecer 'created_by'
            $createdBy = Auth::id();
        }

        // Creación o actualización del usuario
        $user = User::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'] ?? 'defaultPassword'), // Considerar un valor predeterminado seguro si es nulo
                'role' => $data['role'],
                'created_by' => $createdBy,
            ]
        );

        // Manejo de la información adicional del usuario
        UserInformacion::updateOrCreate(
            ['user_id' => $user->id],
            [
                'rut' => $data['rut'],
                'nombre' => $data['name'],
                'apellidos' => $data['apellidos'] ?? null,
                'telefono' => $data['telefono'] ?? null,
                'direccion' => $data['direccion'] ?? null,
                'email' => $data['email'],
            ]
        );

        // Creación o actualización de preferencias solo si el rol no es 'user'
        if ($data['role'] !== 'User') {
            $opcionesPredeterminadas = ['Categorias','Productos', 'Proveedores', 'Descuentos', 'Ventas', 'Rendicion', 'GestionSitio','Contactos'];
            foreach ($opcionesPredeterminadas as $opcion) {
                UserPreferencia::updateOrCreate(
                    ['user_id' => $user->id, 'opcion_nombre' => $opcion],
                    ['estado' => true, 'updated_by' => Auth::id()]
                );
            }
        }

        // Sesión y redirección con mensajes de éxito
        $request->session()->put('usuarioTemp', $data);
        $origin = $request->input('origin', 'register');

        return $origin === 'profile'
            ? redirect()->route('inicio.perfilUsuario')->with('success', 'Usuario creado exitosamente y preferencias establecidas.')
            : redirect()->route('inicio.login')->with('success', 'Cuenta creada exitosamente. Por favor, inicie sesión.');
    }

    //Funcion para las preferencias
    public function actualizarPreferencias(Request $request)
    {
        $userId = $request->input('userId');
        if (is_null($userId)) {
            return back()->with('error', 'El ID del usuario no puede ser nulo.');
        }

        $preferenciasInput = $request->input('preferencias', []);
        $opcionesPredeterminadas = ['Categorias','Productos', 'Proveedores', 'Descuentos', 'Ventas', 'Rendicion','GestionSitio','Contactos'];

        foreach ($opcionesPredeterminadas as $opcion) {
            $estado = array_key_exists($opcion, $preferenciasInput) ? 1 : 0;

            UserPreferencia::updateOrCreate(
                ['user_id' => $userId, 'opcion_nombre' => $opcion],
                ['estado' => $estado, 'updated_by' => Auth::id()] // Registrar quién actualizó la preferencia
            );
        }

        return redirect()->route('inicio.perfilUsuario')->with('success', 'Preferencias actualizadas correctamente.');
    }

    public function eliminar($id)
    {
        // Buscar el usuario por su ID
        $usuario = User::findOrFail($id);

        // Realizar la eliminación del usuario
        $usuario->delete();

        // Redireccionar a una página de confirmación u otra ubicación
        return redirect()->route('inicio.perfilUsuario')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function actualizarUsuario(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'telefono' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'rut' => 'nullable|string|unique:user_informacion,rut,' . $id . ',user_id',
            'mascotas.*.nombre' => 'nullable|string|max:255',
            'mascotas.*.fecha_cumpleanos' => 'nullable|date',
            'mascotas.*.especie' => 'nullable|string|max:255',
            'mascotas.*.raza' => 'nullable|string|max:255',
            'mascotas.*.peso' => 'nullable|numeric|min:0',
            'mascotas.*.unidad' => 'nullable|string|in:kilos,gramos',
        ]);

        // Buscar el usuario por ID
        $user = User::findOrFail($id);

        // Actualizar los datos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Actualizar la información adicional del usuario
        UserInformacion::updateOrCreate(
            ['user_id' => $user->id],
            [
                'telefono' => $request->input('telefono'),
                'direccion' => $request->input('direccion'),
                'rut' => $request->input('rut'),
            ]
        );

        // Actualizar la información de las mascotas
        if ($request->has('mascotas')) {
            foreach ($request->input('mascotas') as $mascotaId => $mascotaData) {
                $mascota = Mascota::findOrFail($mascotaId);

                // Calcular el peso en gramos basado en la unidad seleccionada
                $pesoEnGramos = $mascotaData['unidad'] == 'kilos' 
                    ? $mascotaData['peso'] * 1000 
                    : $mascotaData['peso'];

                $mascota->update([
                    'nombre' => $mascotaData['nombre'],
                    'fecha_cumpleanos' => $mascotaData['fecha_cumpleanos'],
                    'especie' => $mascotaData['especie'],
                    'raza' => $mascotaData['raza'],
                    'peso_en_gramos' => $pesoEnGramos,
                ]);
            }
        }

        // Redireccionar de vuelta con un mensaje de éxito
        return redirect()->route('inicio.perfilUsuario')->with('success', 'Datos del usuario y sus mascotas actualizados correctamente.');
    }

     public function logout(Request $request)
     {
         Auth::logout();
         $request->session()->invalidate();
         $request->session()->regenerateToken();
         return redirect('/');
     }

     
}
