<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->numerify('##########'), // Número aleatorio
            'email' => $this->faker->unique()->safeEmail(),
            'dni' => $this->faker->numerify('########'),
            'activo' => $this->faker->boolean(100),
        ];
    }
}