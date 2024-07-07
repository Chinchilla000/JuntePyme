<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $table = 'detalles_ordens';

    protected $fillable = [
        'orden_id',
        'rut', 
        'phone',
        'first_name',
        'last_name',
        'email',
        'tipo_retiro',
        'direccion',
        'ciudad',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }
    
}
