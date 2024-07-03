<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Informacion extends Model
{
    use HasFactory;

    protected $table = 'informacion'; // Especificar el nombre correcto de la tabla

    protected $fillable = [
        'titulo', 'descripcion', 'imagen', 'tipo', 'apartado', 'color',
        'contenido', 'autor', 'categoria_id', 'tags', 'fecha_publicacion', 'slug', 'metadatos'
    ];

    // Método para generar el slug automáticamente
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->titulo, '-');
            }
        });
    }
} 