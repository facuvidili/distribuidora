@extends('layouts.app')

@section('title', 'Editar Cliente')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection
@section('content_header')
    <h1 class="text-2xl font-semibold">Editar Cliente</h1>
@endsection

@section('content')
    <div class="container mx-auto p-4 bg-white rounded-lg shadow-md">
        <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ $cliente->nombre }}"
                    class="w-full px-3 py-2 border rounded-md" required>
            </div>

            <!-- DNI -->
            <div class="mb-4">
                <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                <input type="number" name="dni" id="dni" value="{{ $cliente->dni }}"
                    class="w-full px-3 py-2 border rounded-md" required max="99999999">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ $cliente->email }}"
                    class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Teléfono -->
            <div class="mb-4">
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="number" name="telefono" id="telefono" value="{{ $cliente->telefono }}"
                    class="w-full px-3 py-2 border rounded-md"  max="99999999999999999999">
            </div>

            <!-- Dirección -->
            <div class="mb-4">
                <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                <input type="text" name="direccion" id="direccion" value="{{ $cliente->direccion }}"
                    class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Botón de actualización -->
            <div class="text-right">
                <button type="submit" class="btn btn-success">Actualizar Cliente</button>
            </div>
        </form>
    </div>
@endsection
