<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Storage;

class CategoriasController extends Controller
{
    public function index(Request $request)
    {
        $categoriasPadre = Categoria::whereNull('categoria_padre_id')
                                    ->orderBy('id', 'asc')
                                    ->paginate(5, ['*'], 'categoriasPadrePage');

        $subcategorias = Categoria::whereNotNull('categoria_padre_id')
                                ->with('categoriaPadre')
                                ->orderBy('id', 'asc')
                                ->paginate(5, ['*'], 'subcategoriasPage');

        return view('categorias.indexCategorias', compact('categoriasPadre', 'subcategorias'));
    }

    public function create()
    {
        $categoriasPadre = Categoria::whereNull('categoria_padre_id')->get();
        return view('categorias.create', compact('categoriasPadre'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
            'imagen_categoria' => 'nullable|image|mimes:jpeg,png,jpg',
            'categoria_padre_id' => 'nullable|exists:categorias,id'
        ]);

        $categoria = new Categoria($validatedData);

        if ($request->hasFile('imagen_categoria')) {
            $rutaImagen = $request->file('imagen_categoria')->store('imagenes_categorias', 'public');
            $categoria->imagen_categoria = basename($rutaImagen);
        }
        
        $categoria->save();
        return redirect()->route('categorias.indexCategorias')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        $productos = $categoria->productos;
        $proveedores = Proveedor::all();
        $categoriasPadre = Categoria::whereNull('categoria_padre_id')->get(); // Solo las categorías padre
    
        return view('categorias.vistaContenidoCategorias', compact('categoria', 'productos', 'proveedores', 'categoriasPadre'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
            'categoria_padre_id' => 'nullable|exists:categorias,id'
        ]);

        $categoria->fill($validatedData);
        $categoria->save();

        return redirect()->route('categorias.contenido', $categoria->id)->with('success', 'Categoría actualizada correctamente.');
    }

    public function updateImage(Request $request, Categoria $categoria)
    {
        $validatedData = $request->validate([
            'imagen_categoria' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('imagen_categoria')) {
            $file = $request->file('imagen_categoria');
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();

            // Eliminar la imagen anterior si existe
            if ($categoria->imagen_categoria && Storage::disk('public')->exists('imagenes_categorias/' . $categoria->imagen_categoria)) {
                Storage::disk('public')->delete('imagenes_categorias/' . $categoria->imagen_categoria);
            }

            // Almacenar la nueva imagen y actualizar el nombre de la imagen en la base de datos
            $rutaImagen = $file->storeAs('imagenes_categorias', $nombreArchivo, 'public');
            $categoria->imagen_categoria = basename($rutaImagen);
        }

        $categoria->save();

        return redirect()->route('categorias.contenido', $categoria->id)->with('success', 'Imagen de categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->imagen_categoria && Storage::disk('public')->exists('imagenes_categorias/' . $categoria->imagen_categoria)) {
            Storage::disk('public')->delete('imagenes_categorias/' . $categoria->imagen_categoria);
        }
        $categoria->delete();
        
        return redirect()->route('categorias.indexCategorias')->with('success', 'Categoría eliminada correctamente.');
    }

    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    public function contenidoCategoria(Categoria $categoria)
    {
        $categoria->load(['subcategorias' => function ($query) {
            $query->with('productos');
        }]);

        $productos = $categoria->productosIncluyendoSubcategorias();
        $categoriasPadre = Categoria::whereNull('categoria_padre_id')->with('subcategorias')->get(); // Asegurarnos de cargar subcategorías
        $proveedores = Proveedor::all();

        return view('categorias.vistaContenidoCategorias', compact('categoria', 'productos', 'categoriasPadre', 'proveedores'));
    }
    

    public function getCategorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
}
