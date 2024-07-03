<?php

namespace App\Http\Controllers\ProductosVentas;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Especificacion;
use App\Models\Informacion;
use App\Models\ProductoDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductosVentasController extends Controller
{
    // Método para mostrar los productos en la vista pública con filtros
    public function index(Request $request)
    {
        // Filtrar los productos que están listos para vender
        $query = Producto::where('estado', 1)->with('descuento'); // Incluir los descuentos en la consulta

        // Aplicar filtros de marca
        if ($request->has('marca')) {
            $query->whereIn('marca', $request->input('marca'));
        }

        // Aplicar filtros de especificaciones (peso, edad mascota, necesidades especiales)
        if ($request->has('peso')) {
            $query->whereHas('especificaciones', function($q) use ($request) {
                $q->where('clave', 'Peso')->whereIn('valor', $request->input('peso'));
            });
        }

        if ($request->has('edad_mascota')) {
            $query->whereHas('especificaciones', function($q) use ($request) {
                $q->where('clave', 'Edad Mascota')->whereIn('valor', $request->input('edad_mascota'));
            });
        }

        if ($request->has('necesidades_especiales')) {
            $query->whereHas('especificaciones', function($q) use ($request) {
                $q->where('clave', 'Necesidades Especiales')->whereIn('valor', $request->input('necesidades_especiales'));
            });
        }

        // Detectar si la URL es para productos con descuento
        $esDescuento = $request->is('descuentosProductos');
        $esWelcome = $request->is('/'); // O la ruta que uses para welcome

        if ($esDescuento) {
            // Filtrar productos que tienen descuento activo
            $hoy = Carbon::now();
            $query->whereHas('descuento', function ($query) use ($hoy) {
                $query->where('inicio', '<=', $hoy)->where('fin', '>=', $hoy);
            });
        }

        if ($esWelcome) {
            $productos = $query->orderBy('nombre', 'asc')->get(); // Obtener todos los productos para welcome
        } else {
            $productos = $query->orderBy('nombre', 'asc')->paginate(16); // Paginación para las otras vistas
        }

        // Obtener opciones de filtro
        $marcas = Producto::where('estado', 1)->distinct()->pluck('marca');
        $pesos = Especificacion::where('clave', 'Peso')->distinct()->pluck('valor');
        $edadesMascota = Especificacion::where('clave', 'Edad Mascota')->distinct()->pluck('valor');
        $necesidadesEspeciales = Especificacion::where('clave', 'Necesidades Especiales')->distinct()->pluck('valor');

        // Obtener los productos destacados
        $productosDestacados = Producto::where('es_destacado', true)->where('estado', 1)->get();

        // Agregar precios finales con descuento a los productos con descuento
        foreach ($productos as $producto) {
            $producto->precio_final = $producto->precio_venta_bruto;
            if ($producto->descuento) {
                if ($producto->descuento->porcentaje) {
                    $producto->precio_final = $producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100);
                } elseif ($producto->descuento->monto) {
                    $producto->precio_final = $producto->precio_venta_bruto - $producto->descuento->monto;
                }
            }
        }

        $viewData = compact('productos', 'marcas', 'pesos', 'edadesMascota', 'necesidadesEspeciales', 'productosDestacados');

        if ($esDescuento) {
            return view('descuentosInicio.descuentos', $viewData);
        }

        if ($esWelcome) {
            $informaciones = Informacion::all();
            $informacionesI = Informacion::where('tipo', 'informativo')->get();
            $categoriasPadre = Categoria::whereNull('categoria_padre_id')->get(); // Solo categorías padre
            $viewData['informaciones'] = $informaciones;
            $viewData['informacionesI'] = $informacionesI;
            $viewData['categoriasPadre'] = $categoriasPadre;
            return view('welcome', $viewData);
        }

        return view('productosprincipal.productos', $viewData);
    }

    // Método para mostrar la página de detalles del producto
    public function show($id)
    {
        $producto = Producto::with('descuento')->findOrFail($id); // Cargar el producto con su descuento
        $especificaciones = Especificacion::where('producto_id', $id)->get(); // Cargar especificaciones del producto
        $comentarios = Comentario::where('producto_id', $id)->latest()->paginate(6); // Cargar comentarios paginados
        $detalles = ProductoDetalle::where('producto_id', $id)->get(); // Cargar detalles adicionales del producto

        // Calcular el precio final considerando el descuento
        $producto->precio_final = $producto->precio_venta_bruto;
        if ($producto->descuento) {
            if ($producto->descuento->porcentaje) {
                $producto->precio_final = $producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100);
            } elseif ($producto->descuento->monto) {
                $producto->precio_final = $producto->precio_venta_bruto - $producto->descuento->monto;
            }
        }

        return view('productosprincipal.productodetalle', compact('producto', 'especificaciones', 'comentarios', 'detalles'));
    }
    

    // Método para mostrar productos por categoría con filtros
    public function showProductsByCategory(Request $request, $categoriaId)
    {
        $categoria = Categoria::findOrFail($categoriaId);
        $filters = $request->all(); // Obtener todos los filtros
    
        $query = Producto::where('estado', 1)
            ->where(function($q) use ($categoria) {
                if ($categoria->categoria_padre_id === null) {
                    $q->where('categoria_id', $categoria->id)
                      ->orWhereIn('categoria_id', $categoria->subcategorias->pluck('id'));
                } else {
                    $q->where('categoria_id', $categoria->id);
                }
            });
    
        // Aplicar filtros de marca
        if ($request->has('marca')) {
            $query->whereIn('marca', $request->input('marca'));
        }
    
        // Aplicar filtros de especificaciones (peso, edad mascota, necesidades especiales)
        if ($request->has('peso')) {
            $query->whereHas('especificaciones', function($q) use ($request) {
                $q->where('clave', 'Peso')->whereIn('valor', $request->input('peso'));
            });
        }
    
        if ($request->has('edad_mascota')) {
            $query->whereHas('especificaciones', function($q) use ($request) {
                $q->where('clave', 'Edad Mascota')->whereIn('valor', $request->input('edad_mascota'));
            });
        }
    
        if ($request->has('necesidades_especiales')) {
            $query->whereHas('especificaciones', function($q) use ($request) {
                $q->where('clave', 'Necesidades Especiales')->whereIn('valor', $request->input('necesidades_especiales'));
            });
        }
    
        // Obtener los productos filtrados
        $productos = $query->orderBy('nombre', 'asc')->paginate(12);
    
        // Obtener opciones de filtro específicas para la categoría o subcategoría actual
        $marcas = Producto::where('estado', 1)
            ->where(function($q) use ($categoria) {
                if ($categoria->categoria_padre_id === null) {
                    $q->where('categoria_id', $categoria->id)
                      ->orWhereIn('categoria_id', $categoria->subcategorias->pluck('id'));
                } else {
                    $q->where('categoria_id', $categoria->id);
                }
            })
            ->distinct()
            ->pluck('marca');
    
        $pesos = Especificacion::whereHas('producto', function($q) use ($categoria) {
                $q->where('estado', 1)
                  ->where(function($q2) use ($categoria) {
                      if ($categoria->categoria_padre_id === null) {
                          $q2->where('categoria_id', $categoria->id)
                             ->orWhereIn('categoria_id', $categoria->subcategorias->pluck('id'));
                      } else {
                          $q2->where('categoria_id', $categoria->id);
                      }
                  });
            })
            ->where('clave', 'Peso')
            ->distinct()
            ->pluck('valor');
    
        $edadesMascota = Especificacion::whereHas('producto', function($q) use ($categoria) {
                $q->where('estado', 1)
                  ->where(function($q2) use ($categoria) {
                      if ($categoria->categoria_padre_id === null) {
                          $q2->where('categoria_id', $categoria->id)
                             ->orWhereIn('categoria_id', $categoria->subcategorias->pluck('id'));
                      } else {
                          $q2->where('categoria_id', $categoria->id);
                      }
                  });
            })
            ->where('clave', 'Edad Mascota')
            ->distinct()
            ->pluck('valor');
    
        $necesidadesEspeciales = Especificacion::whereHas('producto', function($q) use ($categoria) {
                $q->where('estado', 1)
                  ->where(function($q2) use ($categoria) {
                      if ($categoria->categoria_padre_id === null) {
                          $q2->where('categoria_id', $categoria->id)
                             ->orWhereIn('categoria_id', $categoria->subcategorias->pluck('id'));
                      } else {
                          $q2->where('categoria_id', $categoria->id);
                      }
                  });
            })
            ->where('clave', 'Necesidades Especiales')
            ->distinct()
            ->pluck('valor');
    
        return view('productosprincipal.productosVentas', compact('productos', 'categoria', 'marcas', 'pesos', 'edadesMascota', 'necesidadesEspeciales', 'filters'));
    }
    
    
    // Método para buscar productos
    public function buscarProductos(Request $request)
    {
        $query = $request->input('query');

        $productos = Producto::where('estado', 1)
            ->where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('descripcion', 'LIKE', "%{$query}%")
            ->get();

        // Añadir la URL completa de la imagen del producto
        foreach ($productos as $producto) {
            if ($producto->imagen_producto) {
                $producto->imagen_url = asset('storage/imagenes_productos/' . $producto->imagen_producto);
            } else {
                $producto->imagen_url = asset('assets/img/gallery/default.jpg');
            }
        }

        return response()->json($productos);
    }

    // Método para buscar productos por categoría
// Método para buscar productos por categoría
public function buscarProductosPorCategoria(Request $request, $categoriaId)
{
    $query = $request->input('query');
    $categoria = Categoria::findOrFail($categoriaId);

    if ($categoria->categoria_padre_id === null) {
        // Es una categoría padre
        $productos = Producto::where('estado', 1)
                            ->where(function($q) use ($query, $categoria) {
                                $q->where(function($subQuery) use ($query) {
                                    $subQuery->where('nombre', 'LIKE', "%{$query}%");
                                })
                                ->where(function($catQuery) use ($categoria) {
                                    $catQuery->where('categoria_id', $categoria->id)
                                             ->orWhereIn('categoria_id', $categoria->subcategorias->pluck('id'));
                                });
                            })
                            ->get();
    } else {
        // Es una subcategoría
        $productos = Producto::where('estado', 1)
                            ->where('categoria_id', $categoria->id)
                            ->where(function($subQuery) use ($query) {
                                $subQuery->where('nombre', 'LIKE', "%{$query}%");
                            })
                            ->get();
    }

    // Añadir la URL completa de la imagen del producto
    foreach ($productos as $producto) {
        if ($producto->imagen_producto) {
            $producto->imagen_url = asset('storage/imagenes_productos/' . $producto->imagen_producto);
        } else {
            $producto->imagen_url = asset('assets/img/gallery/default.jpg');
        }
        
        // Calcular el precio final
        $producto->precio_final = $producto->precio_venta_bruto;
        if ($producto->descuento) {
            if ($producto->descuento->porcentaje) {
                $producto->precio_final = $producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100);
            } elseif ($producto->descuento->monto) {
                $producto->precio_final = $producto->precio_venta_bruto - $producto->descuento->monto;
            }
        }
    }

    return response()->json($productos);
}


}
