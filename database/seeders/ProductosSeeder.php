<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        Producto::create([
            'codigo' => 'P001',
            'nombre' => 'Laptop Gamer',
            'cantidad' => 10,
            'precio' => 1500.00,
            'proveedor_id' => 1,
            'activo' => true,
        ]);

        Producto::create([
            'codigo' => 'P002',
            'nombre' => 'Mouse Inalámbrico',
            'cantidad' => 50,
            'precio' => 30.00,
            'proveedor_id' => 2,
            'activo' => true,
        ]);

        Producto::create([
            'codigo' => 'P003',
            'nombre' => 'Teclado Mecánico RGB',
            'cantidad' => 30,
            'precio' => 80.00,
            'proveedor_id' => 1,
            'activo' => true,
        ]);
    }
}