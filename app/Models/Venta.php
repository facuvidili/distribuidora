<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id',
        'fecha_venta',
        'total',
        'user_id', // ID del usuario que realizó la venta
    ];

    /**
     * Relación: Una venta pertenece a un cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación: Una venta tiene muchos productos (relación muchos a muchos).
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'venta_producto')
                    ->withPivot('cantidad', 'precio', 'importe');
    }
}