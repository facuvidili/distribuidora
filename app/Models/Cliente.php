<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'dni',
        'nombre',
        'email',
        'telefono',
        'direccion',
        'activo', // Indica si el cliente está activo
    ];

    /**
     * Relación: Un cliente puede realizar varias ventas.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}