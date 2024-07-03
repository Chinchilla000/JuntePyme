<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'direccion'
    ];

    /**
     * Get the products associated with the provider.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    // Aquí puedes añadir más métodos o propiedades según necesites
}
