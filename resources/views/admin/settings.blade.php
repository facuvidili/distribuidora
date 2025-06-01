@extends('layouts.app')

@section('title', 'Configuración')

@section('breadcrumb')
    <li class="breadcrumb-item active">Configuración</li>
@endsection

@section('content_header')
    <h1 class="text-2xl font-semibold">Configuración de Cuenta</h1>
@endsection

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                    <small class="text-gray-500">Déjalo vacío si no deseas cambiar la contraseña.</small>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection