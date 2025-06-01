@extends('layouts.app')

@section('title', 'Agregar Cliente')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content_header')
    <h1 class="text-2xl font-semibold">Agregar Nuevo Cliente</h1>
@endsection

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">

        <div class="mb-4">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold">DNI</label>
                    <input type="number" name="dni" value="{{ old('dni') }}" class="form-control" required max="99999999">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Teléfono</label>
                    <input type="number" name="telefono" value="{{ old('telefono') }}" class="form-control" max="99999999999999999999">
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check-circle"></i> Guardar Cliente
                </button>
            </div>
        </form>
    </div>
@endsection
