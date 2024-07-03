<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'producto_id',
        'nombre',
        'correo',
        'fecha',
        'descripcion',
    ];

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Asegúrate de que 'fecha' sea una instancia de Carbon
    protected $dates = [
        'fecha',
    ];

    // Accessor para formatear la fecha
    public function getFechaAttribute($value)
    {
        return Carbon::parse($value);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}