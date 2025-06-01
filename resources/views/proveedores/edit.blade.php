@extends('layouts.app')

@section('title', 'Editar Proveedor')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content_header')
    <h1 class="text-2xl font-semibold">Editar Proveedor</h1>
@endsection

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">

        <div class="mb-4">
            <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold">DNI</label>
                    <input type="text" name="dni" value="{{ old('dni', $proveedor->dni) }}" class="form-control"
                        required max="99999999">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Razón Social</label>
                    <input type="text" name="razon_social" value="{{ old('razon_social', $proveedor->razon_social) }}"
                        class="form-control" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}"
                        class="form-control" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}"
                        class="form-control">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}"
                        class="form-control" max="99999999999999999999">
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
