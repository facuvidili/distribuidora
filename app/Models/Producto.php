<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'nombre',
        'cantidad',
        'precio',
        'proveedor_id',
        'activo', // Indica si el producto está activo
    ];

    /**
     * Relación: Un producto puede estar en varias ventas.
     */
    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'venta_producto')
                    ->withPivot('cantidad', 'precio', 'importe');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

}