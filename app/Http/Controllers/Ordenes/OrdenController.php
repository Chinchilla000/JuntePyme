<?php

namespace App\Http\Controllers\Ordenes;

use App\Http\Controllers\Controller; // Asegúrate de extender Controller
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\ProblemaOrden;
use Illuminate\Support\Facades\Log;

class OrdenController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $statusMap = [
            'completada' => 'completed',
            'pendiente' => 'pending',
            'rechazada' => 'rejected',
        ];

        $ordenes = Orden::with('user', 'detallesOrden')
            ->where(function($query) use ($searchTerm, $statusMap) {
                if ($searchTerm) {
                    $searchTermLower = strtolower($searchTerm);
                    $query->where('reference', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('user', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', '%' . $searchTerm . '%');
                        })
                        ->orWhere(function ($query) use ($searchTermLower, $statusMap) {
                            if (array_key_exists($searchTermLower, $statusMap)) {
                                $query->where('status', $statusMap[$searchTermLower]);
                            }
                        });
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('ventas.indexOrdenes', compact('ordenes'));
    }

    public function show($id)
    {
        $orden = Orden::with(['user', 'productos' => function ($query) {
            $query->withPivot('cantidad', 'precio', 'descuento');
        }, 'detallesOrden'])->findOrFail($id);

        $problemas = ProblemaOrden::where('orden_id', $id)->get();
        return view('ventas.detallesOrdenes', compact('orden', 'problemas'));
    }

     // Actualizar el estado del pedido
     public function updateReadyForPickup(Request $request, $id)
     {
         $orden = Orden::findOrFail($id);
         $detallesOrden = $orden->detallesOrden;
 
         if ($detallesOrden) {
             if ($detallesOrden->tipo_retiro == 'retiro') {
                 $detallesOrden->update(['listo_para_retiro' => true]);
                 return response()->json(['status' => 'success', 'message' => 'Producto marcado como listo para retiro.']);
             } elseif ($detallesOrden->tipo_retiro == 'domicilio') {
                 if ($detallesOrden->numero_seguimiento && $detallesOrden->proveedor) {
                     $detallesOrden->update(['listo_para_retiro' => true]);
                     return response()->json(['status' => 'success', 'message' => 'Pedido marcado como enviado.']);
                 } else {
                     return response()->json(['status' => 'error', 'message' => 'Complete la información de seguimiento antes de marcar como enviado.']);
                 }
             }
         }
 
         return response()->json(['status' => 'error', 'message' => 'No se pudo actualizar el estado.']);
     }
 
     // Actualizar datos en caso de despacho
     public function updateTracking(Request $request, $id)
     {
         $request->validate([
             'numero_seguimiento' => 'required|string',
             'proveedor' => 'required|string',
         ]);
 
         $orden = Orden::findOrFail($id);
         $detallesOrden = $orden->detallesOrden;
 
         if ($detallesOrden) {
             $detallesOrden->update([
                 'numero_seguimiento' => $request->numero_seguimiento,
                 'proveedor' => $request->proveedor,
             ]);
 
             return response()->json(['status' => 'success', 'message' => 'Información de seguimiento actualizada.']);
         }
 
         return response()->json(['status' => 'error', 'message' => 'No se encontró la orden.']);
     }

     //Apartado para reportar problema
     public function reportProblem(Request $request, $id)
     {
         $request->validate([
             'descripcion_problema' => 'required|string|max:1000',
         ]);
 
         try {
             $orden = Orden::findOrFail($id);
 
             ProblemaOrden::create([
                 'orden_id' => $orden->id,
                 'descripcion' => $request->descripcion_problema,
             ]);
 
             $problemas = ProblemaOrden::where('orden_id', $orden->id)->get();
 
             return response()->json([
                 'status' => 'success',
                 'message' => 'Problema reportado exitosamente.',
                 'problemas' => $problemas
             ]);
         } catch (\Exception $e) {
             Log::error('Error reporting problem:', ['error' => $e->getMessage()]);
             return response()->json(['status' => 'error', 'message' => 'Ocurrió un error al reportar el problema.']);
         }
     }


    //Esto es para la descripcion de los problemas en caso de alguna orden
     public function getProblemas($id)
     {
         try {
             $problemas = ProblemaOrden::where('orden_id', $id)->get();
 
             return response()->json([
                 'status' => 'success',
                 'problemas' => $problemas
             ]);
         } catch (\Exception $e) {
             return response()->json(['status' => 'error', 'message' => 'Ocurrió un error al obtener los problemas.']);
         }
     }
    
     public function deleteProblema($id)
    {
        try {
            $problema = ProblemaOrden::findOrFail($id);
            $problema->delete();

            return response()->json(['status' => 'success', 'message' => 'Problema eliminado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Ocurrió un error al eliminar el problema.']);
        }
    }

    //Metodo para la orden si fue retirada
    public function markAsRetirado($id)
    {
        $orden = Orden::findOrFail($id);
        $detallesOrden = $orden->detallesOrden;
        $detallesOrden->retirado = true;
        $detallesOrden->save();

        return response()->json([
            'status' => 'success',
            'message' => 'El producto ha sido marcado como retirado.'
        ]);
    }

    public function destroy($id)
    {
        $orden = Orden::findOrFail($id);
        $orden->delete();

        return redirect()->route('ordenes.index')->with('success', 'Orden eliminada con éxito.');
    }
}