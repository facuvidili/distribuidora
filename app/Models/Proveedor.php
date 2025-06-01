<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'dni',
        'razon_social',
        'nombre',
        'direccion',
        'telefono',
        'activo', // Indica si el proveedor está activo
    ];

    /** 
     * Definir una relación con los productos (si aplica).
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}