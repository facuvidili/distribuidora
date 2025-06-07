<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word(),
            'codigo' => strtoupper($this->faker->lexify('??????')), // Código aleatorio
            'precio' => $this->faker->randomFloat(2, 10, 1000),
            'cantidad' => $this->faker->numberBetween(1, 50),
            'proveedor_id' => 1 // Puedes cambiar esto dinámicamente en el test
        ];
    }
}