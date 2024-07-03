<?php

namespace App\Http\Controllers\Contacto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Producto;

class ComentarioController extends Controller
{
    public function store(Request $request, $productoId)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255',
            'descripcion' => 'required|string',
        ]);

        $comentario = new Comentario([
            'producto_id' => $productoId,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'fecha' => now(), // Establecer la fecha y hora actual
            'descripcion' => $request->descripcion,
        ]);

        $comentario->save();

        return redirect()->route('productosVentas.show', $productoId)->with('success', 'Comentario agregado exitosamente');
    }
}