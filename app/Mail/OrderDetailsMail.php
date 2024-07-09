<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Orden;

class OrderDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Orden $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $totalConDescuento = 0;
        foreach ($this->order->productos as $producto) {
            $descuento = $producto->pivot->descuento ?? 0;
            $precioConDescuento = $producto->pivot->precio - $descuento;
            $totalConDescuento += $precioConDescuento * $producto->pivot->cantidad;
        }

        return $this->view('emails.orderDetails')
                    ->subject('Detalles de tu Orden')
                    ->with([
                        'order' => $this->order,
                        'totalConDescuento' => $totalConDescuento
                    ]);
    }
}

