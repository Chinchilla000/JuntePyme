<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Producto;
use App\Models\Categoria;
use Carbon\Carbon;

class VerifyDiscounts extends Command
{
    protected $signature = 'discounts:verify';
    protected $description = 'Verificar y actualizar los descuentos expirados';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        // Verificar y actualizar productos con descuentos expirados
        Producto::whereHas('descuento', function ($query) use ($now) {
            $query->where('fin', '<', $now);
        })->update(['descuento_id' => null]);

        // Verificar y actualizar categorías con descuentos expirados
        Categoria::whereHas('descuento', function ($query) use ($now) {
            $query->where('fin', '<', $now);
        })->update(['descuento_id' => null]);

        $this->info('Descuentos expirados verificados y actualizados.');
    }
}
