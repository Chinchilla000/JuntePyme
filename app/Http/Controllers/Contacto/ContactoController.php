<?php

namespace App\Http\Controllers\Contacto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacto;

class ContactoController extends Controller
{
    public function showForm()
    {
        return view('contacto.contacto');
    }

    public function sendContactForm(Request $request)
    {
        $request->validate([
            'contactName' => 'required|string|max:255',
            'contactEmail' => 'required|email|max:255',
            'contactPhone' => 'required|string|max:15',
            'contactMessage' => 'required|string|max:1000',
        ]);

        Contacto::create([
            'nombre' => $request->contactName,
            'email' => $request->contactEmail,
            'telefono' => $request->contactPhone,
            'mensaje' => $request->contactMessage,
        ]);

        return redirect()->back()->with('success', '¡Tu mensaje ha sido enviado exitosamente!');
    }
    public function index()
    {
        $searchTerm = request('searchTerm');
        $contactos = Contacto::query()
            ->when($searchTerm, function($query, $searchTerm) {
                return $query->where('nombre', 'like', "%{$searchTerm}%")
                             ->orWhere('email', 'like', "%{$searchTerm}%")
                             ->orWhere('telefono', 'like', "%{$searchTerm}%");
            })
            ->paginate(10);
        return view('contacto.vistaContactos', compact('contactos'));
    }

    public function destroy($id)
    {
        $contacto = Contacto::findOrFail($id);
        $contacto->delete();

        return redirect()->route('admin.contactos')->with('success', '¡Contacto eliminado correctamente!');
    }
}
