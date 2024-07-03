<?php

namespace App\Http\Controllers\UsuarioPrincipal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function perfilUsuarioComun()
    {
        $usuario = auth()->user();
        $informacion = $usuario->userInformation;
        $mascotas = $usuario->mascotas;
        $mascotas = $usuario->mascotas()->paginate(5, ['*'], 'mascotas_page');
    $ordenes = $usuario->ordenes()->paginate(4, ['*'], 'ordenes_page');
        
        return view('perfiluser.perfiluserprincipal', compact('usuario', 'informacion', 'mascotas', 'ordenes'));
    }
    

    public function updatePerfil(Request $request)
    {
        $usuario = auth()->user();
        $informacion = $usuario->userInformation;

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:255',
            'rut' => 'required|string|unique:user_informacion,rut,' . ($informacion ? $informacion->id : 'NULL') . ',id',
            'apellido' => 'nullable|string|max:255',
            'region' => 'nullable|string',
            'comuna' => 'nullable|string',
            'ciudad' => 'nullable|string',
            'calle' => 'nullable|string',
            'numero' => 'nullable|string',
            'departamento' => 'nullable|string'
        ]);

        try {
            $usuario->update([
                'name' => $validatedData['nombre'],
                'email' => $validatedData['email'],
            ]);

            $infoData = $request->only(['rut', 'apellido', 'telefono', 'region', 'comuna', 'ciudad', 'calle', 'numero', 'departamento']);
            $infoData['nombre'] = $validatedData['nombre'];
            $infoData['email'] = $validatedData['email'];

            if ($informacion) {
                $informacion->update($infoData);
            } else {
                $usuario->userInformation()->create($infoData + ['user_id' => $usuario->id]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error updating profile.');
        }

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = auth()->user();

        if (!Hash::check($request->current_password, $usuario->password)) {
            return redirect()->back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        $usuario->password = Hash::make($request->new_password);
        $usuario->save();

        return redirect()->back()->with('success', 'Contraseña cambiada correctamente');
    }
}
