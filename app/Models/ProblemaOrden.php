<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemaOrden extends Model
{
    use HasFactory;

    protected $table = 'problema_ordenes';

    protected $fillable = [
        'orden_id',
        'descripcion',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }
}