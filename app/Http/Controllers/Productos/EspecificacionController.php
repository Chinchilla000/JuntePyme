<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Especificacion;
use App\Models\ProductoDetalle;

class EspecificacionController extends Controller
{
    public function store(Request $request, $productoId)
    {
        $request->validate([
            'clave' => 'required|string|max:255',
            'valor' => 'required|string|max:255',
        ]);

        Especificacion::create([
            'producto_id' => $productoId,
            'clave' => $request->clave,
            'valor' => $request->valor,
        ]);

        return redirect()->route('productos.edit', $productoId)->with('success', 'Especificación añadida correctamente.');
    }
    public function destroy($id)
    {
        $especificacion = Especificacion::find($id);
        $productoId = $especificacion->producto_id;
        $especificacion->delete();

        return redirect()->route('productos.edit', $productoId)->with('success', 'Especificación eliminada correctamente.');
    }

    public function storeDetalle(Request $request, $productoId)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ]);

        ProductoDetalle::create([
            'producto_id' => $productoId,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('productos.edit', $productoId)->with('success', 'Detalle del producto añadido correctamente.');
    }

    public function destroyDetalle($id)
    {
        $detalle = ProductoDetalle::find($id);
        $productoId = $detalle->producto_id;
        $detalle->delete();

        return redirect()->route('productos.edit', $productoId)->with('success', 'Detalle del producto eliminado correctamente.');
    }
}