<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'codigo_barras',
        'nombre',
        'descripcion',
        'precio_venta_neto',
        'precio_unitario',
        'unidad_de_medida',
        'cantidad_disponible',
        'cantidad_minima',
        'categoria_id',
        'proveedor_id',
        'imagen_producto',
        'marca',
        'estado',
        'fecha_de_vencimiento',
        'descuento_id',
        'es_destacado',
        'iva_venta',
        'precio_venta_bruto',
    ];

    public function ordenes()
    {
        return $this->belongsToMany(Orden::class, 'orden_producto')->withPivot('cantidad', 'precio');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function descuento()
    {
        return $this->belongsTo(Descuento::class, 'descuento_id');
    }

    public function especificaciones()
    {
        return $this->hasMany(Especificacion::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'producto_id');
    }

    public function detalles()
    {
        return $this->hasMany(ProductoDetalle::class, 'producto_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($producto) {
            if ($producto->descuento) {
                $now = Carbon::now();
                if ($producto->descuento->fecha_fin < $now) {
                    $producto->descuento_id = null;
                }
            }
        });
    }
}
