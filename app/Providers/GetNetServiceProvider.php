<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dnetix\Redirection\PlacetoPay;

class GetNetServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('getnet', function ($app) {
            $config = config('getnet');

            return new PlacetoPay([
                'login' => $config['login'],
                'tranKey' => $config['secret_key'],
                'baseUrl' => $config['base_url'],  // Cambiamos 'url' por 'baseUrl'
                'timeout' => 45,  // Timeout configurado directamente aquí
                'connect_timeout' => 30,  // Connect timeout configurado directamente aquí
            ]);
        });
    }

    public function boot()
    {
        //
    }
}
