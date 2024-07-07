<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'producto_id',
        'cantidad',
        'descuento_id',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function descuento()
    {
        return $this->belongsTo(Descuento::class);
    }
}
