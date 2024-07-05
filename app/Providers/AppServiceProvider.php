<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\Categoria;
use App\Models\Producto;
use App\Services\GetNetService;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        // Compartir las categorías con todas las vistas
        $categorias = Categoria::all();
        View::share('categorias', $categorias);

        // Compartir los productos con todas las vistas
        $productos = Producto::all();
        View::share('productos', $productos);

        // Define un acceso común para varios roles
        Gate::define('access-common-areas', function ($user) {
            // Define los roles que tienen acceso
            $allowedRoles = ['admin', 'Vendedor', 'Bodeguero'];
            return in_array($user->role, $allowedRoles);
        });

          // Compartir las categorías con todas las vistas
          View::composer('*', function ($view) {
            $categoriasPadre = Categoria::whereNull('categoria_padre_id')->with('subcategorias')->get();
            $view->with('categoriasPadre', $categoriasPadre);
        });
    }

    public function register()
    {
        $this->app->singleton('getnet', function ($app) {
            return new GetNetService();
        });
    }
}
