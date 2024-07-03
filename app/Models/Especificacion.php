<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especificacion extends Model
{
    use HasFactory;

    protected $table = 'especificaciones';

    protected $fillable = [
        'producto_id',
        'clave',
        'valor',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}