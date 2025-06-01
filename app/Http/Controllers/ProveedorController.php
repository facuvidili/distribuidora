<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    /**
     * Muestra la lista de todos los proveedores.
     */
    public function index()
    {
        try {
            $proveedores = Proveedor::where('activo', 1)->orderBy('razon_social', 'asc')->get();
            return view('proveedores.index', compact('proveedores'));
        } catch (\Exception $e) {
            Log::error("Error al obtener proveedores: " . $e->getMessage());
            session()->flash('error', 'Ocurrió un problema al cargar la lista de proveedores.');
            return redirect()->route('proveedores.index');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Almacena un nuevo proveedor en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'razon_social' => 'required|string|max:255',
                'nombre' => 'required|string|max:255',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'dni' => 'required|unique:proveedores,dni|max:15',
            ]);

            Proveedor::create($request->all() + ['activo' => 1]); // El proveedor se guarda como activo

            session()->flash('success', 'Proveedor agregado correctamente.');
            return redirect()->route('proveedores.index');
        } catch (\Exception $e) {
            Log::error("Error al guardar proveedor: " . $e->getMessage());
            session()->flash('error', 'Error al guardar el proveedor: ' . $e->getMessage());
            return redirect()->route('proveedores.create');
        }
    }

    /**
     * Muestra el formulario de edición de un proveedor.
     */
    public function edit($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            return view('proveedores.edit', compact('proveedor'));
        } catch (\Exception $e) {
            Log::error("Error al obtener proveedor para editar: " . $e->getMessage());
            session()->flash('error', 'No se encontró el proveedor.');
            return redirect()->route('proveedores.index');
        }
    }

    /**
     * Actualiza los datos de un proveedor.
     */
    public function update(Request $request, $id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);

            $request->validate([
                'razon_social' => 'required|string|max:255',
                'nombre' => 'required|string|max:255',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'dni' => 'required|unique:proveedores,dni|max:15',
            ]);

            $proveedor->update($request->all());

            session()->flash('success', 'Proveedor actualizado correctamente.');
            return redirect()->route('proveedores.index');
        } catch (\Exception $e) {
            Log::error("Error al actualizar proveedor: " . $e->getMessage());
            session()->flash('error', 'Error al actualizar el proveedor: ' . $e->getMessage());
            return redirect()->route('proveedores.edit', $id);
        }
    }

    /**
     * Desactiva un proveedor en lugar de eliminarlo físicamente.
     */
    public function destroy($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            // Si el proveedor no tiene productos, se marca como inactivo en lugar de eliminarlo
            $proveedor->update(['activo' => 0]);
            return response()->json(['success' => 'Proveedor eliminado correctamente.']);

        } catch (\Exception $e) {
            Log::error("Error al desactivar proveedor: " . $e->getMessage());
            return response()->json(['error' => 'Hubo un problema al eliminar el proveedor.'], 500);
        }
    }
}