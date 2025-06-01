<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    /**
     * Muestra los datos de la empresa.
     */
    public function show()
    {
        $empresa = Empresa::first(); // Asumimos que hay una única empresa en la base de datos
        return view('empresa.show', compact('empresa'));
    }
    /**
     * Almacena los datos de la empresa en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:empresa,email',
        ]);

        $empresa = Empresa::create($request->all());

        return redirect()->route('empresa.show', ['empresa' => $empresa->id])->with('success', 'Datos de la empresa registrados correctamente.');
    }

    
    /**
     * Muestra el formulario para crear la empresa.
     */
    public function create()
    {
        return view('empresa.create');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit()
    {
        $empresa = Empresa::first();
        return view('empresa.edit', compact('empresa'));
    }

    /**
     * Actualiza los datos de la empresa.
     */
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $empresa->update($request->all());

        return redirect()->route('empresa.show', ['empresa' => $empresa->id])->with('success', 'Datos actualizados correctamente.');
    }
}