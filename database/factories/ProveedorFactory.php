<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition()
    {
        return [
            'dni' => $this->faker->unique()->numerify('##.###.###'), // Formato argentino clásico
            'razon_social' => $this->faker->company(),
            'nombre' => $this->faker->name(),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'activo' => true,
        ];
    }
}