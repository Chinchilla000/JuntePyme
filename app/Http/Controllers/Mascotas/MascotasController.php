<?php

namespace App\Http\Controllers\Mascotas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota; // Asegúrate de usar el modelo correcto
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class MascotasController extends Controller
{
    /**
     * Display a listing of the pets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->id();
        $mascotas = Mascota::where('user_id', $user_id)->get();
    
        return view('perfiluser.perfiluserprincipal', compact('mascotas'));
    }
    
    


    /**
     * Show the form for creating a new pet.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mascotas.create');
    }

    /**
     * Store a newly created pet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Verificar si el usuario tiene el rol 'User' y si ya tiene 5 mascotas
        $mascotasCount = Mascota::where('user_id', $user->id)->count();
        if ($user->role === 'User' && $mascotasCount >= 5) {
            return redirect()->back()->with('error', 'No puedes registrar más de 5 mascotas.');
        }

        // Validar los datos de la mascota
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'especie' => 'required|max:255',
            'raza' => 'nullable|max:255',
            'fecha_cumpleanos' => 'nullable|date',
            'alimento' => 'nullable|max:255',
            'peso' => 'required|numeric',
            'unidad' => 'required|in:kilos,gramos',
            'color' => 'nullable|max:255',
            'sexo' => 'nullable|max:255'
        ]);

        // Convertir el peso a gramos si está en kilos
        if ($validatedData['unidad'] == 'kilos') {
            $validatedData['peso_en_gramos'] = $validatedData['peso'] * 1000;
        } else {
            $validatedData['peso_en_gramos'] = $validatedData['peso'];
        }

        // Agregar user_id a los datos validados
        $validatedData['user_id'] = $user->id;
        unset($validatedData['peso']);
        unset($validatedData['unidad']);

        // Crear la nueva mascota
        Mascota::create($validatedData);
        return redirect()->route('perfiluser')->with('success', 'Mascota creada exitosamente.');
    }
    /**
     * Show the form for editing the specified pet.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mascota = Mascota::findOrFail($id); // Encuentra la mascota o falla
        return view('perfiluser', compact('mascota'));
    }

    /**
     * Update the specified pet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'especie' => 'required|max:255',
            'raza' => 'nullable|max:255',
            'alimento' => 'nullable|max:255',
            'peso' => 'required|numeric',
            'unidad' => 'required|in:kilos,gramos',
            'color' => 'nullable|max:255',
            'sexo' => 'nullable|max:255',
            'fecha_cumpleanos' => 'nullable|date' // Validar fecha de cumpleaños si es administrador
        ]);

        // Convertir el peso a gramos si está en kilos
        if ($validatedData['unidad'] == 'kilos') {
            $validatedData['peso_en_gramos'] = $validatedData['peso'] * 1000;
        } else {
            $validatedData['peso_en_gramos'] = $validatedData['peso'];
        }

        // Actualizar los datos de la mascota
        $mascota = Mascota::findOrFail($id);

        if (auth()->user()->role === 'admin') {
            // Actualizar todos los campos
            $mascota->update($validatedData);
        } else {
            // Actualizar solo los campos permitidos para usuarios no administradores
            unset($validatedData['fecha_cumpleanos']);
            $mascota->update($validatedData);
        }

        return redirect()->route('perfiluser')->with('success', 'Mascota actualizada exitosamente.');
    }

    /**
     * Remove the specified pet from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Solo permitir a los administradores eliminar mascotas
        if (auth()->user()->role === 'admin') {
            $mascota = Mascota::findOrFail($id);
            $mascota->delete();
            return redirect()->back()->with('success', 'Su mascota fue correctamente eliminada.');
        }

        return redirect()->back()->with('error', 'No tienes permiso para eliminar mascotas.');
    }
}
