<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoDetalle extends Model
{
    use HasFactory;

    protected $table = 'productos_detalles'; // Nombre de la tabla

    protected $fillable = [
        'producto_id',
        'titulo',
        'contenido'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}