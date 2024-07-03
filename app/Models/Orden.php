<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $fillable = ['user_id', 'total', 'status', 'reference', 'session_id', 'discount_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function birthdayDiscounts()
    {
        return $this->hasMany(BirthdayDiscount::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'orden_producto')
                    ->withPivot('cantidad', 'precio','descuento');
    }

    public function detallesOrden()
    {
        return $this->hasOne(DetalleOrden::class, 'orden_id');
    }

    public function descuentos()
    {
        return $this->belongsToMany(Descuento::class, 'user_discounts', 'orden_id', 'descuento_id')->withTimestamps();
    }

    public function updateStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->save();

        if ($newStatus == 'completed') {
            $this->descontarCantidadProductos();
        }
    }

    protected function descontarCantidadProductos()
    {
        foreach ($this->productos as $producto) {
            $producto->cantidad_disponible -= $producto->pivot->cantidad;
            $producto->save();
        }
    }

    public function paymentNotifications()
    {
        return $this->hasMany(PaymentNotification::class, 'orden_id');
    }
}
