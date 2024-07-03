<?php

namespace App\Http\Controllers\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Proveedor::orderBy('id', 'asc');

        if ($request->has('searchTerm') && $request->searchTerm != '') {
            $searchTerm = strtolower($request->searchTerm);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', "%{$searchTerm}%")
                ->orWhere('descripcion', 'LIKE', "%{$searchTerm}%")
                ->orWhere('otroCampo', 'LIKE', "%{$searchTerm}%"); // Ejemplo de otro campo relevante
            });
        }

        $proveedores = $query->paginate(5); // Ajusta la paginación según tus necesidades
        return view('proveedores.indexProveedores', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'telefono' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|max:255'
        ]);

        Proveedor::create($validatedData);

        return redirect()->route('proveedores.indexProveedores')->with('success', 'Proveedor creado con éxito.');
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.editarProveedores', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'telefono' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|max:255'
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($validatedData);

        return redirect()->route('proveedores.indexProveedores')->with('success', 'Proveedor actualizado con éxito.');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.indexProveedores')->with('success', 'Proveedor eliminado con éxito.');
    }
}