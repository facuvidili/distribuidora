<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Mostrar listado de usuarios
    public function index()
    {
        $users = User::where('activo',1)->with('rol')->paginate(10); // Paginamos los resultados
        return view('user.index', compact('users'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $roles = Rol::all();
        return view('user.create', compact('roles'));
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'rol_id' => 'required|exists:roles,id'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'activo' => true
        ]);

        return redirect()->route('user.index')->with('success', 'Usuario creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(User $user)
    {
        $roles = Rol::all();
        return view('user.edit', compact('user', 'roles'));
    }

    // Actualizar usuario
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
            'activo' => $request->activo ?? true
        ]);

        return redirect()->route('user.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario
   public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            // Si el proveedor no tiene productos, se marca como inactivo en lugar de eliminarlo
            $user->update(['activo' => 0]);
            return response()->json(['success' => 'Usuario eliminado correctamente.']);

        } catch (\Exception $e) {
            Log::error("Error al desactivar usuario: " . $e->getMessage());
            return response()->json(['error' => 'Hubo un problema al eliminar el usuario.'], 500);
        }
    }
}