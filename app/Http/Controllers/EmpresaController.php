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
            'logo' => 'nullable|image|max:2048' // Validar que sea una imagen de máximo 2MB

        ]);

        $empresa = Empresa::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email
        ]);

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
            'logo' => 'nullable|image|max:2048' // Validar que sea una imagen de máximo 2MB

        ]);

        // Procesar la imagen si se sube una nueva
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Genera nombre único
            $destinationPath = public_path('dist/img'); // Ruta dentro de "public/dist/img"

            $file->move($destinationPath, $fileName); // Mueve la imagen a la carpeta deseada

            $empresa->logo = 'dist/img/' . $fileName; // Guarda la ruta relativa en la BD
        }



        // Guardar cambios
        $empresa->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email
        ]);


        return redirect()->route('empresa.show', ['empresa' => $empresa->id])->with('success', 'Datos actualizados correctamente.');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'image|max:2048', // Solo imágenes, máx. 2MB
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logos');
            $logoUrl = str_replace('public/', 'storage/', $path);

            // Guarda el logo en la BD
            $empresa = Empresa::first();
            $empresa->update(['logo' => $logoUrl]);

            return back()->with('success', 'Logo actualizado correctamente.');
        }

        return back()->with('error', 'Hubo un problema al subir la imagen.');
    }
}
