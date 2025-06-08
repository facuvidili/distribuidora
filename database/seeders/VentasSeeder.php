<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class VentasSeeder extends Seeder
{
    public function run()
    {
        // Creando las ventas
        $venta1 = Venta::create([
            'cliente_id' => 1,
            'fecha_venta' => now(),
            'total' => 2500.00,
            'user_id' => 1,
        ]);

        $venta2 = Venta::create([
            'cliente_id' => 2,
            'fecha_venta' => now()->subDays(1),
            'total' => 850.50,
            'user_id' => 2,
        ]);

        // Asociando productos a cada venta
        DB::table('venta_producto')->insert([
            [
                'venta_id' => $venta1->id,
                'producto_id' => 1, // Laptop Gamer
                'cantidad' => 1,
                'precio' => 1500.00,
                'importe' => 1500.00,
            ],
            [
                'venta_id' => $venta1->id,
                'producto_id' => 2, // Mouse Inalámbrico
                'cantidad' => 2,
                'precio' => 30.00,
                'importe' => 60.00,
            ],
            [
                'venta_id' => $venta2->id,
                'producto_id' => 3, // Teclado Mecánico
                'cantidad' => 1,
                'precio' => 80.00,
                'importe' => 80.00,
            ]
        ]);
    }
}