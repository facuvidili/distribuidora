<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;

class VentaController extends Controller
{
    /**
     * Muestra la lista de todas las ventas registradas.
     */
    public function index()
    {
        try {
            $ventas = Venta::with('cliente')->orderBy('fecha_venta', 'desc')->get();
            return view('ventas.index', compact('ventas'));
        } catch (\Exception $e) {
            Log::error("Error al obtener ventas: " . $e->getMessage());
            session()->flash('error', 'Ocurrió un problema al cargar la lista de ventas.');
            return redirect()->route('ventas.index');
        }
    }

    /**
     * Muestra los detalles de una venta específica.
     */
    public function show($id)
    {
        try {
            $venta = Venta::with(['productos' => function ($query) {
                $query->select('productos.*', 'venta_producto.cantidad', 'venta_producto.precio', 'venta_producto.importe');
            }])->findOrFail($id);

            return view('ventas.show', compact('venta'));
        } catch (\Exception $e) {
            Log::error("Error al obtener detalles de la venta: " . $e->getMessage());
            session()->flash('error', 'No se encontró la venta.');
            return redirect()->route('ventas.index');
        }
    }

    /**
     * Muestra el formulario para registrar una nueva venta.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Guarda una nueva venta en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'productos' => 'required|array',
                'cantidad' => 'required|array',
            ]);

            // Validar disponibilidad de stock antes de crear la venta
            foreach ($request->productos as $index => $producto_id) {
                $producto = Producto::findOrFail($producto_id);
                $cantidad = $request->cantidad[$index];

                if ($producto->cantidad < $cantidad) {
                    session()->flash('error', 'Stock insuficiente para ' . $producto->nombre);
                    return redirect()->back();
                }
            }

            // Si pasamos la validación de stock, ahora creamos la venta
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'fecha_venta' => now(),
                'total' => 0,
                'user_id' => auth()->id(),
            ]);

            $total = 0;
            foreach ($request->productos as $index => $producto_id) {
                $producto = Producto::findOrFail($producto_id);
                $cantidad = $request->cantidad[$index];

                // Restar stock disponible
                $producto->decrement('cantidad', $cantidad);

                // Guardar relación en la venta
                $venta->productos()->attach($producto->id, [
                    'cantidad' => $cantidad,
                    'precio' => $producto->precio,
                    'importe' => $producto->precio * $cantidad,
                ]);

                $total += $producto->precio * $cantidad;
            }

            // Actualizar el total de la venta
            $venta->update(['total' => $total]);

            session()->flash('success', 'Venta registrada correctamente.');
            return redirect()->route('ventas.index');
        } catch (\Exception $e) {
            Log::error("Error al registrar la venta: " . $e->getMessage());
            session()->flash('error', 'Error al registrar la venta: ' . $e->getMessage());
            return redirect()->route('ventas.create');
        }
    }

    /**
     * Muestra el formulario para editar una venta.
     */
    public function edit($id)
    {
        try {
            $venta = Venta::with('productos')->findOrFail($id);
            $clientes = Cliente::all();
            $productos = Producto::all();

            $total = $venta->productos->sum(fn($producto) => $producto->pivot->importe);

            return view('ventas.edit', compact('venta', 'clientes', 'productos', 'total'));
        } catch (\Exception $e) {
            Log::error("Error al obtener venta para editar: " . $e->getMessage());
            session()->flash('error', 'No se encontró la venta.');
            return redirect()->route('ventas.index');
        }
    }

    /**
     * Actualiza los datos de una venta.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'productos' => 'required|array',
                'cantidad' => 'required|array',
            ]);

            $venta = Venta::findOrFail($id);

             // Validar disponibilidad de stock antes de crear la venta
            foreach ($request->productos as $index => $producto_id) {
                $producto = Producto::findOrFail($producto_id);
                $cantidad = $request->cantidad[$index];

                if ($producto->cantidad < $cantidad) {
                    session()->flash('error', 'Stock insuficiente para ' . $producto->nombre);
                    return redirect()->back();
                }
            }

            $venta->update(['cliente_id' => $request->cliente_id]);
            
            foreach ($venta->productos as $producto) {
                // Devolver el stock de los productos que estaban en la venta
                $producto->increment('cantidad', $producto->pivot->cantidad);
            }
            $venta->productos()->detach();

            
            $total = 0;
            foreach ($request->productos as $index => $producto_id) {
                $producto = Producto::findOrFail($producto_id);
                $cantidad = $request->cantidad[$index];
                
                // Restar stock disponible
                $producto->decrement('cantidad', $cantidad);

                $venta->productos()->attach($producto->id, [
                    'cantidad' => $cantidad,
                    'precio' => $producto->precio,
                    'importe' => $producto->precio * $cantidad,
                ]);

                $total += $producto->precio * $cantidad;
            }

            $venta->update(['total' => $total]);

            session()->flash('success', 'Venta actualizada correctamente.');
            return redirect()->route('ventas.index');
        } catch (\Exception $e) {
            Log::error("Error al actualizar la venta: " . $e->getMessage());
            session()->flash('error', 'Error al actualizar la venta: ' . $e->getMessage());
            return redirect()->route('ventas.edit', $id);
        }
    }

    /**
     * Elimina una venta de la base de datos.
     */
    public function destroy($id)
    {
        try {
            $venta = Venta::findOrFail($id);

            foreach ($venta->productos as $producto) {
                $producto->increment('cantidad', $producto->pivot->cantidad);
            }

            $venta->productos()->detach();
            $venta->delete();

            return response()->json(['success' => 'Venta eliminada correctamente.']);
        } catch (\Exception $e) {
            Log::error("Error al eliminar venta: " . $e->getMessage());
            return response()->json(['error' => 'Hubo un problema al eliminar la venta.'], 500);
        }
    }
}
