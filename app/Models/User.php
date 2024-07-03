<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'created_by'
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userInformation()
    {
        return $this->hasOne(UserInformacion::class);
    }

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function usedDiscounts()
    {
        return $this->belongsToMany(Descuento::class, 'user_discounts')
                    ->withPivot('orden_id', 'created_at', 'updated_at');
    }

    public function birthdayDiscounts()
    {
        return $this->hasMany(BirthdayDiscount::class);
    }
}
