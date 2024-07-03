<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformacion extends Model
{
    use HasFactory;

    protected $table = 'user_informacion';

    protected $fillable = [
        'user_id',
        'rut',
        'nombre',
        'apellido',
        'telefono',
        'email',
        'region',
        'comuna',
        'ciudad',
        'calle',
        'numero',
        'departamento'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mascotas()
    {
        return $this->hasMany(Mascota::class,'user_id');
    }
}
