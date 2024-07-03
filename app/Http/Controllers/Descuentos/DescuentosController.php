<?php

namespace App\Http\Controllers\Descuentos;

use App\Http\Controllers\Controller;
use App\Models\Descuento;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DescuentosController extends Controller
{
    public function index(Request $request)
    {
        $query = Descuento::orderBy('id', 'asc');

        if ($request->has('searchTerm') && $request->searchTerm != '') {
            $searchTerm = strtolower($request->searchTerm);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('descripcion', 'LIKE', "%{$searchTerm}%");
            });
        }

        $descuentos = $query->paginate(5);
        return view('descuentos.indexDescuentos', compact('descuentos'));
    }

    public function create()
    {
        return view('descuentos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'monto' => 'nullable|numeric',
            'porcentaje' => 'nullable|numeric',
            'codigo_promocional' => 'nullable|string',
            'tipo_descuento_codigo' => 'nullable|string',
            'monto_codigo' => 'nullable|numeric',
            'porcentaje_codigo' => 'nullable|numeric',
            'inicio' => 'required|date_format:Y-m-d\TH:i',
            'fin' => 'required|date_format:Y-m-d\TH:i'
        ]);

        $descuento = new Descuento();
        $descuento->nombre = $validatedData['nombre'];
        $descuento->inicio = $validatedData['inicio'];
        $descuento->fin = $validatedData['fin'];

        if ($request->tipo_descuento === 'monto') {
            $descuento->monto = $validatedData['monto'];
        } elseif ($request->tipo_descuento === 'porcentaje') {
            $descuento->porcentaje = $validatedData['porcentaje'];
        } elseif ($request->tipo_descuento === 'codigo') {
            $descuento->codigo_promocional = $validatedData['codigo_promocional'];
            if ($request->tipo_descuento_codigo === 'monto_codigo') {
                $descuento->monto = $validatedData['monto_codigo'];
            } elseif ($request->tipo_descuento_codigo === 'porcentaje_codigo') {
                $descuento->porcentaje = $validatedData['porcentaje_codigo'];
            }
        }

        $descuento->save();

        return redirect()->route('descuentos.indexDescuentos')->with('success', 'Descuento creado con éxito.');
    }

    public function edit($id)
    {
        $descuento = Descuento::findOrFail($id);
        return view('descuentos.edit', compact('descuento'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'monto' => 'nullable|numeric',
            'porcentaje' => 'nullable|numeric',
            'inicio' => 'required|date_format:Y-m-d\TH:i',
            'fin' => 'required|date_format:Y-m-d\TH:i'
        ]);

        $descuento = Descuento::findOrFail($id);
        $descuento->update($validatedData);

        return redirect()->route('descuentos.indexDescuentos')->with('success', 'Descuento actualizado con éxito.');
    }

    public function destroy($id)
    {
        $descuento = Descuento::findOrFail($id);
        $descuento->delete();

        // Al eliminar el descuento, se actualizan los productos y categorías asociados
        Producto::where('descuento_id', $id)->update(['descuento_id' => null]);
        Categoria::where('descuento_id', $id)->update(['descuento_id' => null]);

        return redirect()->route('descuentos.indexDescuentos')->with('success', 'Descuento eliminado con éxito.');
    }

    public function detalles($id)
    {
        $descuento = Descuento::findOrFail($id);
        $productos = Producto::all();
        $categorias = Categoria::whereNull('categoria_padre_id')->get();
        $subcategorias = Categoria::whereNotNull('categoria_padre_id')->get();

        return view('descuentos.detalleDescuentos', compact('descuento', 'productos', 'categorias', 'subcategorias'));
    }

    public function aplicar(Request $request, $id)
    {
        $descuento = Descuento::findOrFail($id);
    
        // Desmarcar todos los productos, categorías y subcategorías del descuento
        Producto::where('descuento_id', $descuento->id)->update(['descuento_id' => null]);
        Categoria::where('descuento_id', $descuento->id)->update(['descuento_id' => null]);
    
        // Aplicar a los productos seleccionados
        if ($request->has('productos')) {
            Producto::whereIn('id', $request->productos)->update(['descuento_id' => $descuento->id]);
        }
    
        // Aplicar a las categorías seleccionadas
        if ($request->has('categorias')) {
            Categoria::whereIn('id', $request->categorias)->update(['descuento_id' => $descuento->id]);
        }
    
        // Aplicar a las subcategorías seleccionadas
        if ($request->has('subcategorias')) {
            Categoria::whereIn('id', $request->subcategorias)->update(['descuento_id' => $descuento->id]);
        }
    
        return redirect()->route('descuentos.indexDescuentos')->with('success', 'Descuento aplicado correctamente.');
    }

    public function aplicarCodigoPromocional(Request $request)
    {
        $codigo = $request->input('codigo_promocional');
        $descuento = Descuento::where('codigo_promocional', $codigo)->first();

        if (!$descuento) {
            return response()->json(['error' => 'Código promocional no válido.'], 400);
        }

        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Debe estar autenticado para usar un código promocional.'], 401);
        }

        $user = Auth::user();

        // Verificar si el usuario ya ha usado este código de descuento
        if ($user->usedDiscounts()->where('descuento_id', $descuento->id)->exists()) {
            return response()->json(['error' => 'Ya ha utilizado este código de descuento.'], 400);
        }

        // Guardar el código promocional en la sesión
        session(['discount_code' => $codigo]);
        session(['discount_amount' => $descuento->porcentaje ? $descuento->porcentaje : $descuento->monto]);
        session(['discount_type' => $descuento->porcentaje ? 'porcentaje' : 'monto']);

        Log::info('Descuento aplicado: ', session()->all());

        return response()->json(['success' => 'Código promocional aplicado con éxito.']);
    }

    public function eliminarCodigoPromocional()
    {
        session()->forget(['discount_code', 'discount_amount', 'discount_type']);

        return response()->json(['success' => 'Código promocional eliminado con éxito.']);
    }
    public function checkBirthdayDiscount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $mascotas = $user->mascotas->filter(function ($mascota) {
                return $mascota->isBirthday();
            });
    
            if ($mascotas->isNotEmpty()) {
                session(['birthday_discount' => 10]); // Por ejemplo, 10% de descuento
                Log::info('Descuento de cumpleaños añadido a la sesión.');
            } else {
                session()->forget('birthday_discount');
                Log::info('No hay mascotas de cumpleaños.');
            }
        }
    }
    
    public function calcularTotalConDescuentos(Request $request)
    {
        Log::info('Iniciando cálculo de descuentos.');
    
        // Asegúrate de que el descuento de cumpleaños esté presente en la sesión
        $this->checkBirthdayDiscount();
    
        $cart = session('cart', []);
        $subtotal = 0;
        $descuentosAplicados = [];
        $totalDescuentoProductos = 0;
    
        // Calcular el subtotal y los descuentos de los productos
        foreach ($cart as $item) {
            $producto = Producto::find($item['id']);
            $precioProducto = $producto->precio_venta_bruto;
            $subtotal += $precioProducto * $item['quantity'];
    
            if ($producto->descuento) {
                $descuentoProducto = $producto->descuento;
                if ($descuentoProducto->porcentaje) {
                    $descuento = ($precioProducto * $descuentoProducto->porcentaje) / 100;
                    $porcentaje = $descuentoProducto->porcentaje;
                } else {
                    $descuento = $descuentoProducto->monto;
                    $porcentaje = round(($descuento / $precioProducto) * 100, 2); // Calcular el porcentaje basado en el monto
                }
                $totalDescuentoProductos += $descuento * $item['quantity'];
                $nombreProducto = strlen($producto->nombre) > 20 ? substr($producto->nombre, 0, 20) . '...' : $producto->nombre;
                $descuentosAplicados[] = [
                    'nombre' => $nombreProducto, // Utilizamos 'nombre' para referirnos al nombre del producto
                    'descuento' => number_format($descuento * $item['quantity'], 0, ',', '.'), // Formateo de número chileno
                    'porcentaje' => number_format($porcentaje, 2, ',', '.') // Formateo de número chileno
                ];
            }
        }
    
        $subtotalConDescuentos = $subtotal - $totalDescuentoProductos;
    
        Log::info('Subtotal con descuentos de productos:', ['subtotalConDescuentos' => $subtotalConDescuentos]);
    
        $discountAmount = 0;
        $discountType = null;
        $birthdayDiscountApplied = false;
    
        // Aplicar descuento de cumpleaños si existe
        if (session()->has('birthday_discount')) {
            $birthdayDiscount = session('birthday_discount');
            $mascotas = Auth::user()->mascotas->filter(function ($mascota) {
                return $mascota->isBirthday();
            });
    
            if ($mascotas->isNotEmpty()) {
                Log::info('Mascotas de cumpleaños:', ['mascotas' => $mascotas->pluck('nombre')]);
                $discountAmount = ($subtotalConDescuentos * $birthdayDiscount) / 100;
                $discountType = 'porcentaje';
    
                foreach ($mascotas as $mascota) {
                    $descuentosAplicados[] = [
                        'nombre' => 'Descuento de cumpleaños para ' . $mascota->nombre,
                        'descuento' => number_format($discountAmount, 0, ',', '.'), // Formateo de número chileno
                        'porcentaje' => number_format($birthdayDiscount, 2, ',', '.') // Formateo de número chileno
                    ];
                }
    
                $birthdayDiscountApplied = true;
                Log::info('Descuento de cumpleaños aplicado:', ['discountAmount' => $discountAmount]);
            } else {
                Log::info('No hay mascotas de cumpleaños.');
            }
        } else {
            Log::info('No hay descuento de cumpleaños en la sesión.');
        }
    
        // Aplicar descuento promocional si existe y no se ha aplicado un descuento de cumpleaños
        if (!$birthdayDiscountApplied && session()->has('discount_code')) {
            $discountAmount = session('discount_amount');
            $discountType = session('discount_type');
    
            if ($discountType === 'porcentaje') {
                $discountAmount = ($subtotalConDescuentos * $discountAmount) / 100;
            }
            $descuentosAplicados[] = [
                'nombre' => 'Código Promocional',
                'descuento' => number_format($discountAmount, 0, ',', '.'), // Formateo de número chileno
                'porcentaje' => number_format(session('discount_amount'), 2, ',', '.') // Formateo de número chileno
            ];
    
            Log::info('Descuento promocional aplicado:', ['discountAmount' => $discountAmount]);
        }
    
        $totalConDescuento = $subtotalConDescuentos - $discountAmount;
    
        Log::info('Total con descuento:', ['totalConDescuento' => $totalConDescuento]);
    
        return response()->json([
            'totalConDescuento' => number_format($totalConDescuento, 0, ',', '.'), // Formateo de número chileno
            'discountAmount' => number_format($discountAmount, 0, ',', '.'), // Formateo de número chileno
            'discountType' => $discountType,
            'descuentosAplicados' => $descuentosAplicados,
        ]);
    }
    

}