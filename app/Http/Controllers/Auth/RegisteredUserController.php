<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInformacion;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'User', // Asumiendo que todos los registrados por este método son 'User'
        ]);
    
        event(new Registered($user));
    
        // Crear una entrada en la tabla 'user_informacion' asociada a este usuario
        UserInformacion::create([
            'user_id' => $user->id,
            'nombre' => $user->name,
            'email' => $user->email,
            'apellido' => null,
            'telefono' => null,
            'rut' => null,
            'region' => null,
            'comuna' => null,
            'ciudad' => null,
            'calle' => null,
            'numero' => null,
            'departamento' => null,
            // Puedes establecer otros campos en null si no tienes valores para ellos en este momento
        ]);
    
        Auth::login($user);
    
        // Redirigir a diferentes rutas basadas en el rol del usuario
        if ($user->role === 'User') {
            return redirect('/');
        }
    
        return redirect(route('inicio', absolute: false));
    }
    
}
