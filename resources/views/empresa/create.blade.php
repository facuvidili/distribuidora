@extends('layouts.app')

@section('title', 'Registrar Empresa')
@section('breadcrumb')
    <li class="breadcrumb-item active">Registrar Empresa</li>
@endsection

@section('content_header')
    <h1 class="text-2xl font-semibold">Registrar Nueva Empresa</h1>
@endsection

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">

        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al inicio
            </a>
        </div>

        <form method="POST" action="{{ route('empresa.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nombre" class="block text-gray-700 font-semibold">Nombre de la Empresa</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <div>
                    <label for="direccion" class="block text-gray-700 font-semibold">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" required>
                </div>

                <div>
                    <label for="telefono" class="block text-gray-700 font-semibold">Teléfono</label>
                    <input type="number" name="telefono" id="telefono" class="form-control" required max="99999999999999999999">
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check-circle"></i> Registrar Empresa
                </button>
            </div>
        </form>
    </div>
@endsection