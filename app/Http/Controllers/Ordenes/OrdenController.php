<?php

namespace App\Http\Controllers\Ordenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\ProblemaOrden;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReadyForPickupMail;

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

        $ordenes = Orden::with('user', 'detalleOrden')
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
        $orden = Orden::with(['productos' => function ($query) {
            $query->withPivot('cantidad', 'precio', 'descuento');
        }, 'detalleOrden'])->findOrFail($id);
    
        $problemas = ProblemaOrden::where('orden_id', $id)->get();
        return view('ventas.detallesOrdenes', compact('orden', 'problemas'));
    }
    
    public function updateReadyForPickup(Request $request, $id)
    {
        $orden = Orden::findOrFail($id);
        $detalleOrden = $orden->detalleOrden;

        if ($detalleOrden) {
            if ($detalleOrden->tipo_retiro == 'retiro') {
                $detalleOrden->update(['listo_para_retiro' => true]);
                return response()->json(['status' => 'success', 'message' => 'Producto marcado como listo para retiro.']);
            } elseif ($detalleOrden->tipo_retiro == 'domicilio') {
                if ($detalleOrden->numero_seguimiento && $detalleOrden->proveedor) {
                    $detalleOrden->update(['listo_para_retiro' => true]);
                    return response()->json(['status' => 'success', 'message' => 'Pedido marcado como enviado.']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Complete la información de seguimiento antes de marcar como enviado.']);
                }
            }
        }

        return response()->json(['status' => 'error', 'message' => 'No se pudo actualizar el estado.']);
    }

    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'numero_seguimiento' => 'required|string',
            'proveedor' => 'required|string',
        ]);

        $orden = Orden::findOrFail($id);
        $detalleOrden = $orden->detalleOrden;

        if ($detalleOrden) {
            $detalleOrden->update([
                'numero_seguimiento' => $request->numero_seguimiento,
                'proveedor' => $request->proveedor,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Información de seguimiento actualizada.']);
        }

        return response()->json(['status' => 'error', 'message' => 'No se encontró la orden.']);
    }

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

    public function markAsRetirado($id)
    {
        $orden = Orden::findOrFail($id);
        $detalleOrden = $orden->detalleOrden;
        $detalleOrden->retirado = true;
        $detalleOrden->save();

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


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string',
        ]);

        $orden = Orden::findOrFail($id);
        $orden->status = $request->estado;
        $orden->save();

        // Enviar correo cuando el estado sea "ready_for_pickup" o "completed"
        if ($orden->status == 'ready_for_pickup' || $orden->status == 'completed') {
            Mail::to($orden->detalleOrden->email)->send(new OrderReadyForPickupMail($orden));
        }

        return redirect()->route('ordenes.show', $orden->id)->with('success', 'Estado de la orden actualizado exitosamente.');
    }
    public function sendReadyForPickupEmail($id)
    {
        try {
            $orden = Orden::findOrFail($id);
            Mail::to($orden->detalleOrden->email)->send(new OrderReadyForPickupMail($orden));
    
            return redirect()->route('ordenes.show', $id)->with('success', 'Correo enviado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error sending ready for pickup email:', ['error' => $e->getMessage()]);
            return redirect()->route('ordenes.show', $id)->with('error', 'Ocurrió un error al enviar el correo.');
        }
    }
    

}