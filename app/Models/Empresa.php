<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    // Definir la tabla asociada
    protected $table = 'empresa';

    // Campos que se pueden actualizar masivamente
    protected $fillable = ['nombre', 'direccion', 'telefono', 'email'];
}