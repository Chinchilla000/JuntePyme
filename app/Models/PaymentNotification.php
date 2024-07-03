<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'message',
        'reason',
        'date',
        'request_id',
        'reference',
        'signature',
        'orden_id'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }
}
