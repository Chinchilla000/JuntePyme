<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'imagen_categoria', 'categoria_padre_id', 'descuento_id'];

    // Relaciones existentes
    public function subcategorias() {
        return $this->hasMany(Categoria::class, 'categoria_padre_id');
    }

    public function categoriaPadre() {
        return $this->belongsTo(Categoria::class, 'categoria_padre_id');
    }

    public function productos() {
        return $this->hasMany(Producto::class);
    }

    // Relación con Descuento
    public function descuento() {
        return $this->belongsTo(Descuento::class, 'descuento_id');
    }

    // Método para obtener todos los productos de la categoría y sus subcategorías
    public function productosIncluyendoSubcategorias() {
        $todosLosProductos = $this->productos;
        foreach ($this->subcategorias as $subcategoria) {
            $todosLosProductos = $todosLosProductos->merge($subcategoria->productosIncluyendoSubcategorias());
        }
        return $todosLosProductos;
    }
}
