<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreferencia extends Model
{
    use HasFactory;

    protected $table = 'user_preferencias';

    protected $fillable = [
        'user_id',
        'opcion_nombre',
        'estado',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}