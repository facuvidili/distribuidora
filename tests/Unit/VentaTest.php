<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Proveedor;

class VentaTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;
    /** @test */
    public function una_venta_se_puede_crear_correctamente()
    {
        // Crear un cliente para la venta
        $cliente = Cliente::factory()->create();

        // Crear una venta
        $venta = Venta::create([
            'cliente_id' => $cliente->id,
            'fecha_venta' => now('America/Argentina/Buenos_Aires'),
            'total' => 150.50,
            'user_id' => 1 // Simulación de usuario
        ]);

        // Verificar que la venta se haya creado
        $this->assertDatabaseHas('ventas', [
            'cliente_id' => $cliente->id,
            'total' => 150.50
        ]);
    }

    /** @test */
    public function una_venta_puede_tener_productos_relacionados()
    {
        $cliente = Cliente::factory()->create();
        $venta = Venta::factory()->create(['cliente_id' => $cliente->id]);
        $provedor = Proveedor::factory()->create();
        $producto = Producto::factory()->create();

        // Asociar un producto con la venta
        $venta->productos()->attach($producto->id, ['cantidad' => 2, 'precio' => 50, 'importe' => 100]);

        // Verificar relación
        $this->assertTrue($venta->productos->contains($producto));
        $this->assertEquals(100, $venta->productos->first()->pivot->importe);
    }

    /** @test */
    public function una_venta_pertenece_a_un_cliente()
    {
        $cliente = Cliente::factory()->create();
        $venta = Venta::factory()->create(['cliente_id' => $cliente->id]);

        // Verificar la relación
        $this->assertEquals($cliente->id, $venta->cliente->id);
    }
}