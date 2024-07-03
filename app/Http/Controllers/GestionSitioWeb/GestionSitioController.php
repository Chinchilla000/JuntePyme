<?php

namespace App\Http\Controllers\GestionSitioWeb;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Contacto;
use App\Models\Informacion;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GestionSitioController extends Controller
{
    public function index(Request $request)
    {
        $informacionesEncabezado = Informacion::where('tipo', 'encabezado')->paginate(5);
        $informacionesInformativas = Informacion::where('tipo', 'informativo')->paginate(5);
    
        $productosDestacados = Producto::where('es_destacado', true)->get();
    
        $today = Carbon::today();
        $mensajesRecibidosHoy = Contacto::whereDate('created_at', $today)->count();
        $mensajesRecibidos = Contacto::whereDate('created_at', $today)->get();
        $comentarios = Comentario::with('producto')->paginate(5);
        $comentarioMasReciente = Comentario::latest()->first();
    
        return view('inicio.gestionSitioWeb', compact(
            'informacionesEncabezado', 
            'informacionesInformativas', 
            'productosDestacados', 
            'mensajesRecibidosHoy',
            'mensajesRecibidos',
            'comentarios',
            'comentarioMasReciente'
        ));
    }
    
    public function searchProducts(Request $request)
    {
        $query = $request->get('query', '');
        $productos = Producto::where('nombre', 'like', "%{$query}%")->get();
    
        return response()->json($productos);
    }
    

    public function actualizarProductosDestacados(Request $request)
    {
        $productos = $request->input('productos', []);
    
        // Desmarcar todos los productos
        Producto::where('es_destacado', true)->update(['es_destacado' => false]);
    
        // Marcar los productos seleccionados
        Producto::whereIn('id', $productos)->update(['es_destacado' => true]);
    
        return response()->json(['success' => '¡Productos destacados actualizados correctamente!']);
    }
    
    
    public function agregarContenido(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipo' => 'required|string|in:encabezado,informativo',
        ]);

        $imagenNombre = time().'.'.$request->imagen->extension();
        $request->imagen->storeAs('public/imagenes_gestion', $imagenNombre);

        Informacion::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => 'storage/imagenes_gestion/'.$imagenNombre,
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('inicio.gestionSitioWeb')->with('success', '¡Contenido agregado correctamente!');
    }

    public function editarContenido(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $informacion = Informacion::findOrFail($id);

        if($request->hasFile('imagen')) {
            if ($informacion->imagen) {
                Storage::delete('public/imagenes_gestion/' . basename($informacion->imagen));
            }

            $imagenNombre = time().'.'.$request->imagen->extension();
            $request->imagen->storeAs('public/imagenes_gestion', $imagenNombre);
            $informacion->imagen = 'storage/imagenes_gestion/'.$imagenNombre;
        }

        $informacion->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('inicio.gestionSitioWeb')->with('success', '¡Contenido editado correctamente!');
    }

    public function eliminarContenido($id)
    {
        $informacion = Informacion::findOrFail($id);
        
        if ($informacion->imagen) {
            Storage::delete('public/imagenes_gestion/' . basename($informacion->imagen));
        }

        $informacion->delete();

        return redirect()->route('inicio.gestionSitioWeb')->with('success', '¡Contenido eliminado correctamente!');
    }

    public function updateHeader(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $informacion = Informacion::findOrFail($id);
    
        if ($request->hasFile('imagen')) {
            if ($informacion->imagen) {
                Storage::delete('public/imagenes_gestion/' . basename($informacion->imagen));
            }
    
            $imagenNombre = time().'.'.$request->imagen->extension();
            $request->imagen->storeAs('public/imagenes_gestion', $imagenNombre);
            $informacion->imagen = 'storage/imagenes_gestion/'.$imagenNombre;
        }
    
        $informacion->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion
        ]);
    
        return redirect()->route('inicio.gestionSitioWeb')->with('success', '¡Header actualizado correctamente!');
    }
    
    public function eliminarHeader($id)
    {
        $informacion = Informacion::findOrFail($id);
        
        if ($informacion->imagen) {
            Storage::delete('public/imagenes_gestion/' . basename($informacion->imagen));
        }
    
        $informacion->delete();
    
        return redirect()->route('inicio.gestionSitioWeb')->with('success', '¡Header eliminado correctamente!');
    }


    public function verServicio($id)
    {
        $informacion = Informacion::findOrFail($id);
        return view('servicios.servicios', compact('informacion'));
    }

    public function mostrarServicios()
    {
        $informaciones = Informacion::where('tipo', 'informativo')->get();
        return view('servicios.vistaServicios', compact('informaciones'));
    }

    public function crearInformacionDetallada($id)
    {
        $informacion = Informacion::findOrFail($id);
        $categorias = Categoria::whereNull('categoria_padre_id')->with('subcategorias')->get();
        return view('inicio.editarServicios', compact('informacion', 'categorias'));
    }

    public function guardarInformacionDetallada(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:informacion,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
            'contenido' => 'required|string|max:2000',
            'autor' => 'required|string|max:255',
            'tags' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $informacion = Informacion::find($request->id);
    
        if ($request->hasFile('imagen')) {
            if ($informacion->imagen) {
                Storage::delete('public/imagenes_gestion/' . basename($informacion->imagen));
            }
    
            $imagenNombre = time().'.'.$request->imagen->extension();
            $request->imagen->storeAs('public/imagenes_gestion', $imagenNombre);
            $informacion->imagen = 'storage/imagenes_gestion/'.$imagenNombre;
        }
    
        $informacion->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'contenido' => $request->contenido,
            'autor' => $request->autor,
            'tags' => $request->tags,
        ]);
    
        return redirect()->route('informacion.crearDetallada', $informacion->id)->with('success', '¡Contenido detallado agregado correctamente!');
    }
    
    

    public function eliminarComentario($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return redirect()->route('inicio.gestionSitioWeb')->with('success', 'Comentario eliminado exitosamente');
    }

    public function eliminarInformacion($id)
    {
        $informacion = Informacion::findOrFail($id);
        
        if ($informacion->imagen) {
            Storage::delete('public/imagenes_gestion/' . basename($informacion->imagen));
        }

        $informacion->delete();

        return redirect()->route('inicio.gestionSitioWeb')->with('success', '¡Información eliminada correctamente!');
    }
}
