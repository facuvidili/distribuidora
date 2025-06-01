@extends('layouts.app')

@section('title', 'Agregar Producto')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content_header')
    <h1 class="text-2xl font-semibold">Agregar Nuevo Producto</h1>
@endsection

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">

        <div class="mb-4">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold">Código</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Nombre del Producto</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Precio</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" class="form-control"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Cantidad</label>
                    <input type="number" name="cantidad" value="{{ old('cantidad') }}" class="form-control" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Proveedor</label>
                    <select name="proveedor_id" class="form-control" required>
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->razon_social }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check-circle"></i> Guardar Producto
                </button>
            </div>
        </form>
    </div>
@endsection
