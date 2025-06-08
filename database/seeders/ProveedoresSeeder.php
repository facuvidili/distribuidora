<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedoresSeeder extends Seeder
{
    public function run()
    {
        Proveedor::create([
            'dni' => '30214567',
            'razon_social' => 'Tech Solutions S.A.',
            'nombre' => 'Carlos Rodríguez',
            'direccion' => 'Av. Tecnología 123',
            'telefono' => '1122334455',
            'activo' => true,
        ]);

        Proveedor::create([
            'dni' => '45236789',
            'razon_social' => 'Distribuidora Express',
            'nombre' => 'Mariana Gómez',
            'direccion' => 'Calle Comercio 456',
            'telefono' => '2233445566',
            'activo' => true,
        ]);

        Proveedor::create([
            'dni' => '50678912',
            'razon_social' => 'Electro Global S.R.L.',
            'nombre' => 'Alejandro Torres',
            'direccion' => 'Parque Industrial 789',
            'telefono' => '3344556677',
            'activo' => false,
        ]);
    }
}