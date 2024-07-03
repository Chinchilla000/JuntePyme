<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthdayDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'mascota_id', 'orden_id', 'fecha_uso'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }
}
