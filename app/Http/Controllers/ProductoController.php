<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de todos los productos.
     */
    public function index()
    {
        try {
            $productos = Producto::where('activo', 1)->orderBy('nombre', 'asc')->get();
            return view('productos.index', compact('productos'));
        } catch (\Exception $e) {
            Log::error("Error al obtener productos: " . $e->getMessage());
            session()->flash('error', 'Ocurrió un problema al cargar la lista de productos.');
            return redirect()->route('productos.index');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        try {
            $proveedores = Proveedor::where('activo', 1)->orderBy('razon_social', 'asc')->get();
            return view('productos.create', compact('proveedores'));
        } catch (\Exception $e) {
            Log::error("Error al cargar el formulario de productos: " . $e->getMessage());
            session()->flash('error', 'Ocurrió un problema al cargar el formulario de productos.');
            return redirect()->route('productos.index');
        }
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'cantidad' => 'required|integer|min:0',
                'precio' => 'required|numeric|min:0',
                'codigo' => 'required|integer|min:1',
                'proveedor_id' => 'nullable|exists:proveedores,id',
            ]);

            Producto::create($request->all() + ['activo' => 1]); // Se guarda como activo

            session()->flash('success', 'Producto agregado correctamente.');
            return redirect()->route('productos.index');
        } catch (\Exception $e) {
            Log::error("Error al guardar el producto: " . $e->getMessage());
            session()->flash('error', 'Error al guardar el producto: ' . $e->getMessage());
            return redirect()->route('productos.create');
        }
    }

    /**
     * Muestra el formulario de edición de un producto.
     */
    public function edit($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $proveedores = Proveedor::where('activo', 1)->orderBy('razon_social', 'asc')->get();
            return view('productos.edit', compact('producto', 'proveedores'));
        } catch (\Exception $e) {
            Log::error("Error al cargar la edición de producto: " . $e->getMessage());
            session()->flash('error', 'No se encontró el producto.');
            return redirect()->route('productos.index');
        }
    }

    /**
     * Actualiza los datos de un producto.
     */
    public function update(Request $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'cantidad' => 'required|integer|min:0',
                'precio' => 'required|numeric|min:0',
                'codigo' => 'required|string|max:255',
                'proveedor_id' => 'nullable|exists:proveedores,id',
            ]);

            $producto->update($request->all());

            session()->flash('success', 'Producto actualizado correctamente.');
            return redirect()->route('productos.index');
        } catch (\Exception $e) {
            Log::error("Error al actualizar el producto: " . $e->getMessage());
            session()->flash('error', 'Error al actualizar el producto: ' . $e->getMessage());
            return redirect()->route('productos.edit', $id);
        }
    }

    /**
     * Desactiva un producto en lugar de eliminarlo físicamente.
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);

            // Cambiar el estado a inactivo en lugar de eliminarlo
            $producto->update(['activo' => 0]);

            return response()->json(['success' => 'Producto eliminado correctamente.']);
        } catch (\Exception $e) {
            Log::error("Error al eliminar producto: " . $e->getMessage());
            return response()->json(['error' => 'Hubo un problema al eliminado el producto.'], 500);
        }
    }
}