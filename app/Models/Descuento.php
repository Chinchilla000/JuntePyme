<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Descuento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'monto', 'porcentaje', 'inicio', 'fin', 'codigo_promocional'];

    protected $dates = ['inicio', 'fin'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'descuento_id');
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'descuento_id');
    }

    public function getFormattedDescuentoAttribute()
    {
        if ($this->porcentaje) {
            return intval($this->porcentaje);
        } elseif ($this->monto) {
            return number_format($this->monto, 0, ',', '.');
        }
        return null;
    }

    public function getDiasRestantesAttribute()
    {
        $now = Carbon::now();
        $end = Carbon::parse($this->fin);

        if ($end->isPast()) {
            return 'Expirado';
        }

        $diffInTotalSeconds = $now->diffInSeconds($end, false);
        $diffInDays = intdiv($diffInTotalSeconds, 86400); // 86400 segundos en un día
        $diffInHours = intdiv($diffInTotalSeconds % 86400, 3600); // obtener el residuo de los segundos para las horas
        $diffInMinutes = intdiv($diffInTotalSeconds % 3600, 60); // obtener el residuo de los segundos para los minutos
        $diffInSeconds = $diffInTotalSeconds % 60; // obtener el residuo de los segundos para los segundos restantes

        if ($diffInDays > 0) {
            return $diffInDays . ' días restantes';
        } elseif ($diffInHours > 0) {
            return $diffInHours . ' horas restantes';
        } elseif ($diffInMinutes > 0) {
            return $diffInMinutes . ' minutos restantes';
        } elseif ($diffInSeconds > 0) {
            return $diffInSeconds . ' segundos restantes';
        } else {
            return 'Expirado';
        }
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_discounts')
                    ->withPivot('orden_id', 'created_at', 'updated_at');
    }
}
