<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    /**
     * Muestra la lista de todos los clientes.
     */
    public function index()
    {
        try {
            $clientes = Cliente::where('activo', 1)->orderBy('nombre', 'asc')->get();
            return view('clientes.index', compact('clientes'));
        } catch (\Exception $e) {
            Log::error("Error al obtener clientes: " . $e->getMessage());
            session()->flash('error', 'Ocurrió un problema al cargar la lista de clientes.');
            return redirect()->route('clientes.index');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'dni' => 'required|unique:clientes,dni|max:15',
                'nombre' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'telefono' => 'nullable|string|max:20',
                'direccion' => 'nullable|string|max:255',
            ]);

            Cliente::create($request->all() + ['activo' => 1]); // Se guarda como activo

            session()->flash('success', 'Cliente agregado correctamente.');
            return redirect()->route('clientes.index');
        } catch (\Exception $e) {
            Log::error("Error al guardar cliente: " . $e->getMessage());
            session()->flash('error', 'Error al guardar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.create');
        }
    }

    /**
     * Muestra el formulario de edición de un cliente.
     */
    public function edit($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            return view('clientes.edit', compact('cliente'));
        } catch (\Exception $e) {
            Log::error("Error al obtener cliente para editar: " . $e->getMessage());
            session()->flash('error', 'No se encontró el cliente.');
            return redirect()->route('clientes.index');
        }
    }

    /**
     * Actualiza los datos de un cliente.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'dni' => 'required|string|max:15',
                'nombre' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'telefono' => 'nullable|string|max:20',
                'direccion' => 'nullable|string|max:255',
            ]);

            $cliente = Cliente::findOrFail($id);
            $cliente->update($request->all());

            session()->flash('success', 'Cliente actualizado correctamente.');
            return redirect()->route('clientes.index');
        } catch (\Exception $e) {
            Log::error("Error al actualizar cliente: " . $e->getMessage());
            session()->flash('error', 'Error al actualizar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.edit', $id);
        }
    }

    /**
     * Desactiva un cliente en lugar de eliminarlo físicamente.
     */
    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);

            // Si el cliente no tiene ventas, se marca como inactivo en lugar de eliminarlo
            $cliente->update(['activo' => 0]);
            return response()->json(['success' => 'Cliente eliminado correctamente.']);

        } catch (\Exception $e) {
            Log::error("Error al eliminar cliente: " . $e->getMessage());
            return response()->json(['error' => 'Hubo un problema al eliminar el cliente.'], 500);
        }
    }
}