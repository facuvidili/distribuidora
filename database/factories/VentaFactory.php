<?php

namespace Database\Factories;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    protected $model = Venta::class;

    public function definition()
    {
        return [
            'cliente_id' => 1, // Se puede cambiar dinámicamente en el test
            'fecha_venta' => $this->faker->dateTime(),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'user_id' => 1,
        ];
    }
}