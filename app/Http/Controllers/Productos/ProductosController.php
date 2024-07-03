<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Especificacion;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\ProductoDetalle;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::orderBy('id', 'asc');

        if ($request->has('searchTerm') && $request->searchTerm != '') {
            $searchTerm = strtolower($request->searchTerm);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', "%{$searchTerm}%")
                ->orWhere('codigo_barras', 'LIKE', "%{$searchTerm}%")
                ->orWhere('marca', 'LIKE', "%{$searchTerm}%");
            });
        }

        $proveedores = Proveedor::all();
        $categorias = Categoria::with('subcategorias')->whereNull('categoria_padre_id')->get();

        $productos = $query->paginate(5);
        return view('productos.indexProductos', compact('productos', 'proveedores', 'categorias'));
    }

    public function publicIndex(Request $request)
    {
        $query = Producto::orderBy('nombre', 'asc'); // Ordena por nombre para que sea más amigable para los usuarios

        if ($request->has('searchTerm') && $request->searchTerm != '') {
            $searchTerm = strtolower($request->searchTerm);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('descripcion', 'LIKE', "%{$searchTerm}%");
            });
        }

        $productos = $query->paginate(10); // Ajusta la paginación según tus necesidades

        return view('productos.publicIndex', compact('productos')); // Asegúrate de tener una vista 'publicIndex' para esto
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $categorias = Categoria::all();
        return view('productos.crearProducto', compact('proveedores', 'categorias'));
    }

    public function store(Request $request)
    {
        Log::info('Iniciando creación de producto.', $request->all());
    
        $validatedData = $request->validate([
            'codigo' => 'nullable',
            'codigo_barras' => 'nullable|string',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'marca' => 'required|string',
            'precio_venta_bruto' => 'required|numeric',
            'cantidad_disponible' => 'required|numeric',
            'unidad_de_medida' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'nullable|exists:proveedores,id'
        ]);
    
        Log::info('Datos validados', $validatedData);
    
        // Verificar si el código ya existe
        if ($request->codigo && Producto::where('codigo', $request->codigo)->exists()) {
            Log::warning('El código ya existe', ['codigo' => $request->codigo]);
            return redirect()->back()->with('error', 'El código ya existe. Por favor, ingrese otro código.');
        }
    
        // Calcular IVA y precio de venta neto si se proporciona precio de venta bruto
        if (isset($validatedData['precio_venta_bruto'])) {
            $validatedData['precio_venta_neto'] = $validatedData['precio_venta_bruto'] / 1.19;
            $validatedData['iva_venta'] = $validatedData['precio_venta_bruto'] - $validatedData['precio_venta_neto'];
        }
    
        // Asignar valores por defecto
        $validatedData['estado'] = 0;
        $validatedData['es_destacado'] = 0;
    
        try {
            $producto = new Producto($validatedData);
    
            if ($request->hasFile('imagen_producto')) {
                $nombreArchivo = $request->file('imagen_producto')->store('imagenes_productos', 'public');
                $producto->imagen_producto = basename($nombreArchivo);
                Log::info('Imagen subida', ['imagen_producto' => $producto->imagen_producto]);
            }
    
            $producto->save();
            Log::info('Producto creado', ['producto' => $producto]);
    
            return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear producto', ['error' => $e->getMessage()]);
            return redirect()->route('productos.index')->with('error', 'Error al crear el producto.');
        }
    }
    

    public function edit($id)
    {
        $producto = Producto::find($id);
        $proveedores = Proveedor::all();
        $categorias = Categoria::all();
        $especificaciones = Especificacion::where('producto_id', $id)->get();
        $detalles = ProductoDetalle::where('producto_id', $id)->get(); // Cargar los detalles del producto
        if (!$producto) {
            return redirect('/productos')->with('error', 'Producto no encontrado.');
        }

        return view('productos.editarProductos', compact('producto', 'proveedores', 'categorias', 'especificaciones','detalles'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return redirect('/productos')->with('error', 'Producto no encontrado.');
        }
    
        $validatedData = $request->validate([
            'codigo' => 'nullable',
            'codigo_barras' => 'nullable|string',
            'nombre' => 'required|unique:productos,nombre,' . $id,
            'descripcion' => 'nullable|string',
            'marca' => 'required|string',
            'precio_venta_neto' => 'nullable|numeric',
            'iva_venta' => 'nullable|numeric',
            'precio_venta_bruto' => 'required|numeric',
            'precio_unitario' => 'nullable|numeric',
            'unidad_de_medida' => 'required|string',
            'cantidad_disponible' => 'required|numeric',
            'cantidad_minima' => 'nullable|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'fecha_de_vencimiento' => 'nullable|date',
            'imagen_producto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'estado' => 'required|boolean',
        ]);
    
        // Verificar si el código ya existe para otro producto
        if ($request->codigo && Producto::where('codigo', $request->codigo)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'El código ya existe. Por favor, ingrese otro código.');
        }
    
        // Calcular IVA y precio de venta neto si se proporciona precio de venta bruto
        if (isset($validatedData['precio_venta_bruto'])) {
            $validatedData['precio_venta_neto'] = $validatedData['precio_venta_bruto'] / 1.19;
            $validatedData['iva_venta'] = $validatedData['precio_venta_bruto'] - $validatedData['precio_venta_neto'];
        }
    
        $producto->fill($validatedData);
    
        if ($request->hasFile('imagen_producto')) {
            if ($producto->imagen_producto && Storage::disk('public')->exists('imagenes_productos/' . $producto->imagen_producto)) {
                Storage::disk('public')->delete('imagenes_productos/' . $producto->imagen_producto);
            }
            $nombreArchivo = $request->file('imagen_producto')->store('imagenes_productos', 'public');
            $producto->imagen_producto = basename($nombreArchivo);
        }
    
        $producto->save();
    
        // Almacenar especificaciones si están presentes
        if ($request->has('especificaciones')) {
            foreach ($request->especificaciones as $especificacion) {
                Especificacion::updateOrCreate(
                    ['producto_id' => $producto->id, 'clave' => $especificacion['clave']],
                    ['valor' => $especificacion['valor']]
                );
            }
        }
    
        return redirect()->back()->with('success', 'Producto actualizado correctamente.');
    }
    

    public function destroy($id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return redirect('/productos')->with('error', 'Producto no encontrado.');
        }

        if ($producto->imagen_producto && Storage::disk('public')->exists('imagenes_productos/' . $producto->imagen_producto)) {
            Storage::disk('public')->delete('imagenes_productos/' . $producto->imagen_producto);
        }
        $producto->delete();
        return redirect('/productos')->with('success', 'Producto eliminado correctamente.');
    }

    public function updateImage(Request $request, $id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return redirect('/productos')->with('error', 'Producto no encontrado.');
        }

        $request->validate([
            'imagen_producto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('imagen_producto')) {
            // Comprueba si ya existe una imagen y elimínala si es así
            if (!empty($producto->imagen_producto)) {
                $existingImagePath = 'imagenes_productos/' . $producto->imagen_producto;
                if (Storage::disk('public')->exists($existingImagePath)) {
                    Storage::disk('public')->delete($existingImagePath);
                }
            }

            // Guardar la nueva imagen y actualizar el nombre de la imagen en el modelo
            $nombreArchivo = $request->file('imagen_producto')->store('imagenes_productos', 'public');
            $producto->imagen_producto = basename($nombreArchivo);
            $producto->save();
        }

        return redirect()->route('productos.edit', $producto->id)->with('success', 'Imagen del producto actualizada correctamente.');
    }
}
