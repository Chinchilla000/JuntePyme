<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Orden;

class OrderReadyForPickupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Orden $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->view('emails.orderReadyForPickup')
                    ->subject('Tu pedido está listo para retirar')
                    ->with([
                        'order' => $this->order,
                    ]);
    }
}
