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
use Illuminate\Support\Facades\Log;

class ProductosVentasController extends Controller
{
    // Método para mostrar los productos en la vista pública con filtros
    public function index(Request $request)
    {
        // Filtrar los productos que están listos para vender
        $query = Producto::where('estado', 1)->with(['descuento', 'categoria', 'especificaciones']);

        // Aplicar filtros de marca
        if ($request->has('marca')) {
            $query->whereIn('marca', $request->input('marca'));
        }

        // Aplicar filtros de precio
        if ($request->has('precio')) {
            $precios = $request->input('precio');
            foreach ($precios as $precioRango) {
                $precioRango = explode('-', $precioRango);
                $precioMin = $precioRango[0];
                $precioMax = $precioRango[1];
                $query->whereBetween('precio_venta_bruto', [$precioMin, $precioMax]);
            }
        }

        // Aplicar filtros de tipo de trabajo
        if ($request->has('tipo_trabajo')) {
            $query->whereHas('especificaciones', function($q) use ($request) {
                $q->where('clave', 'Tipo de Trabajo')->whereIn('valor', $request->input('tipo_trabajo'));
            });
        }

        // Aplicar filtros de otras especificaciones
        if ($request->has('otra_especificacion')) {
            $query->whereHas('especificaciones', function($q) use ($request) {
                $q->where('clave', 'Otra Especificación')->whereIn('valor', $request->input('otra_especificacion'));
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
        $productosDestacados = Producto::where('es_destacado', true)->where('estado', 1)->distinct()->get();
        $viewData['productosDestacados'] = $productosDestacados;

        // Obtener categorías y subcategorías
        $categoriasPadre = Categoria::with('subcategorias')->whereNull('categoria_padre_id')->get();
        $viewData['categoriasPadre'] = $categoriasPadre;

        // Obtener todos los productos para calcular los rangos de precios
        $todosLosProductos = Producto::where('estado', 1)->get();
        $minPrice = floor($todosLosProductos->min('precio_venta_bruto') / 1000) * 1000;
        $maxPrice = ceil($todosLosProductos->max('precio_venta_bruto') / 1000) * 1000;

        $precios = [];
        for ($i = $minPrice; $i <= $maxPrice; $i += 5000) {
            $precios[] = [
                'min' => $i,
                'max' => $i + 4999
            ];
        }

        // Obtener opciones de filtro específicas para la categoría o subcategoría actual
        $tiposTrabajo = Especificacion::where('clave', 'Tipo de Trabajo')
            ->distinct()
            ->pluck('valor');

        $otrasEspecificaciones = Especificacion::where('clave', 'Otra Especificación')
            ->distinct()
            ->pluck('valor');

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

        $viewData = compact('productos', 'marcas', 'pesos', 'edadesMascota', 'necesidadesEspeciales', 'productosDestacados', 'categoriasPadre', 'precios', 'tiposTrabajo', 'otrasEspecificaciones');

        if ($esDescuento) {
            return view('descuentosInicio.descuentos', $viewData);
        }

        if ($esWelcome) {
            $informaciones = Informacion::all();
            $informacionesI = Informacion::where('tipo', 'informativo')->get();
            $viewData['informaciones'] = $informaciones;
            $viewData['informacionesI'] = $informacionesI;
            return view('welcome', $viewData);
        }

        return view('productosprincipal.productos', $viewData);
    }

public function show($id)
{
    Log::info("Entrando al método show con el ID: {$id}");

    try {
        $producto = Producto::with('categoria', 'descuento', 'especificaciones', 'comentarios')->findOrFail($id);
        Log::info("Producto encontrado: ", $producto->toArray());

        // Calcular el precio final considerando el descuento
        $producto->precio_final = $producto->precio_venta_bruto;
        if ($producto->descuento) {
            if ($producto->descuento->porcentaje) {
                $producto->precio_final = $producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100);
            } elseif ($producto->descuento->monto) {
                $producto->precio_final = $producto->precio_venta_bruto - $producto->descuento->monto;
            }
        }

        // Obtener productos de la misma categoría
        $productosRelacionados = Producto::where('categoria_id', $producto->categoria_id)
                                        ->where('id', '!=', $producto->id) // Excluir el producto actual
                                        ->where('estado', 1) // Solo productos activos
                                        ->take(10) // Limitar la cantidad de productos relacionados
                                        ->get();

        // Calcular el precio final para los productos relacionados
        foreach ($productosRelacionados as $relacionado) {
            $relacionado->precio_final = $relacionado->precio_venta_bruto;
            if ($relacionado->descuento) {
                if ($relacionado->descuento->porcentaje) {
                    $relacionado->precio_final = $relacionado->precio_venta_bruto * (1 - $relacionado->descuento->porcentaje / 100);
                } elseif ($relacionado->descuento->monto) {
                    $relacionado->precio_final = $relacionado->precio_venta_bruto - $relacionado->descuento->monto;
                }
            }
        }

        // Obtener los primeros 5 comentarios
        $comentarios = $producto->comentarios()->take(5)->get();

        Log::info("Productos relacionados: ", $productosRelacionados->toArray());

        return view('productosprincipal.productodetalle', compact('producto', 'productosRelacionados', 'comentarios'));

    } catch (\Exception $e) {
        Log::error("Error al obtener el producto con ID: {$id}. Error: {$e->getMessage()}");
        return abort(404, 'Producto no encontrado');
    }
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
        $query->whereHas('especificaciones', function($q) use ($request) {
            $q->where('clave', 'Marca')->whereIn('valor', $request->input('marca'));
        });
    }

    // Aplicar filtros de precio
    if ($request->has('precio')) {
        $precios = $request->input('precio');
        foreach ($precios as $precioRango) {
            $precioRango = explode('-', $precioRango);
            $precioMin = $precioRango[0];
            $precioMax = $precioRango[1];
            $query->whereBetween('precio_venta_bruto', [$precioMin, $precioMax]);
        }
    }

    // Aplicar filtros de tipo de trabajo
    if ($request->has('tipo_trabajo')) {
        $query->whereHas('especificaciones', function($q) use ($request) {
            $q->where('clave', 'Tipo de Trabajo')->whereIn('valor', $request->input('tipo_trabajo'));
        });
    }

    // Aplicar filtros de otras especificaciones
    if ($request->has('otra_especificacion')) {
        $query->whereHas('especificaciones', function($q) use ($request) {
            $q->where('clave', 'Otra Especificación')->whereIn('valor', $request->input('otra_especificacion'));
        });
    }

    // Obtener los productos filtrados
    $productos = $query->orderBy('nombre', 'asc')->paginate(12);

    // Obtener rangos de precios dinámicamente basados en todos los productos de la categoría
    $todosLosProductos = Producto::where('estado', 1)
        ->where(function($q) use ($categoria) {
            if ($categoria->categoria_padre_id === null) {
                $q->where('categoria_id', $categoria->id)
                ->orWhereIn('categoria_id', $categoria->subcategorias->pluck('id'));
            } else {
                $q->where('categoria_id', $categoria->id);
            }
        })
        ->get();

    $minPrice = floor($todosLosProductos->min('precio_venta_bruto') / 1000) * 1000;
    $maxPrice = ceil($todosLosProductos->max('precio_venta_bruto') / 1000) * 1000;

    $precios = [];
    for ($i = $minPrice; $i <= $maxPrice; $i += 5000) {
        $precios[] = [
            'min' => $i,
            'max' => $i + 4999
        ];
    }

    // Obtener opciones de filtro específicas para la categoría o subcategoría actual
    $marcas = Especificacion::where('clave', 'Marca')
        ->whereHas('producto', function($q) use ($categoria) {
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
        ->distinct()
        ->pluck('valor');

    $tiposTrabajo = Especificacion::where('clave', 'Tipo de Trabajo')
        ->whereHas('producto', function($q) use ($categoria) {
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
        ->distinct()
        ->pluck('valor');

    $otrasEspecificaciones = Especificacion::where('clave', 'Otra Especificación')
        ->whereHas('producto', function($q) use ($categoria) {
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
        ->distinct()
        ->pluck('valor');

    // Calcular precio final con descuento
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

    return view('productosprincipal.productosVentas', compact('productos', 'categoria', 'marcas', 'precios', 'tiposTrabajo', 'otrasEspecificaciones', 'filters'));
}

    // Método para buscar productos por categoría
    public function buscar(Request $request, $categoriaId)
    {
        $query = $request->input('query');
        $categoria = Categoria::findOrFail($categoriaId);

        // Filtrar productos por categoría y búsqueda
        $productos = Producto::where('estado', 1)
            ->where('categoria_id', $categoria->id)
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%")
                ->orWhere('descripcion', 'LIKE', "%{$query}%");
            })
            ->paginate(12);

        // Obtener rangos de precios dinámicamente basados en todos los productos de la categoría
        $todosLosProductos = Producto::where('estado', 1)
            ->where(function($q) use ($categoria) {
                if ($categoria->categoria_padre_id === null) {
                    $q->where('categoria_id', $categoria->id)
                    ->orWhereIn('categoria_id', $categoria->subcategorias->pluck('id'));
                } else {
                    $q->where('categoria_id', $categoria->id);
                }
            })
            ->get();

        $minPrice = floor($todosLosProductos->min('precio_venta_bruto') / 1000) * 1000;
        $maxPrice = ceil($todosLosProductos->max('precio_venta_bruto') / 1000) * 1000;

        $precios = [];
        for ($i = $minPrice; $i <= $maxPrice; $i += 5000) {
            $precios[] = [
                'min' => $i,
                'max' => $i + 4999
            ];
        }

        // Obtener opciones de filtro específicas para la categoría actual
        $marcas = Producto::where('estado', 1)
            ->distinct()
            ->pluck('marca');

        $tiposTrabajo = Especificacion::where('clave', 'Tipo de Trabajo')
            ->whereHas('producto', function($q) use ($categoria) {
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
            ->distinct()
            ->pluck('valor');

        $otrasEspecificaciones = Especificacion::where('clave', 'Otra Especificación')
            ->whereHas('producto', function($q) use ($categoria) {
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
            ->distinct()
            ->pluck('valor');

        // Calcular precio final con descuento
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

        return view('productosprincipal.productosVentas', compact('productos', 'categoria', 'marcas', 'precios', 'tiposTrabajo', 'otrasEspecificaciones'));
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
