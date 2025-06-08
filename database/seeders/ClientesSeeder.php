<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClientesSeeder extends Seeder
{
    public function run()
    {
        Cliente::create([
            'dni' => '12345678',
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'telefono' => '1112345678',
            'direccion' => 'Av. Principal 123',
            'activo' => true,
        ]);

        Cliente::create([
            'dni' => '87654321',
            'nombre' => 'María González',
            'email' => 'maria@example.com',
            'telefono' => '2223456789',
            'direccion' => 'Calle Secundaria 456',
            'activo' => true,
        ]);

        Cliente::create([
            'dni' => '56789012',
            'nombre' => 'Carlos López',
            'email' => 'carlos@example.com',
            'telefono' => '3334567890',
            'direccion' => 'Barrio Norte 789',
            'activo' => false,
        ]);
    }
}