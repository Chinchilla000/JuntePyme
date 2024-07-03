<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\UserPreferencia;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $preferenciasUsuario = [];
            if (Auth::check()) {
                $user = Auth::user();
                $preferenciasUsuario = UserPreferencia::where('user_id', $user->id)
                    ->pluck('estado', 'opcion_nombre')
                    ->toArray();
            }

            $view->with('preferenciasUsuario', $preferenciasUsuario);
        });
    }
}
