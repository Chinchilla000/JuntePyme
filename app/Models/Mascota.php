<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'fecha_cumpleanos',
        'alimento',
        'especie',
        'raza',
        'peso_en_gramos',
        'color',
        'sexo',
    ];

    protected $dates = ['fecha_cumpleanos'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function isBirthday()
{
    return $this->fecha_cumpleanos->isToday();
}


    public function getPesoEnKilosAttribute()
    {
        return $this->peso_en_gramos / 1000;
    }

    public function setPesoEnKilosAttribute($value)
    {
        $this->attributes['peso_en_gramos'] = $value * 1000;
    }

    public function getPesoYUnidadAttribute()
    {
        if ($this->peso_en_gramos === null) {
            return ['peso' => 0, 'unidad' => 'gramos']; // Valor por defecto si peso_en_gramos es null
        } elseif ($this->peso_en_gramos < 1000) {
            return ['peso' => $this->peso_en_gramos, 'unidad' => 'gramos'];
        } else {
            return ['peso' => $this->peso_en_gramos / 1000, 'unidad' => 'kilos'];
        }
    }
}
