@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content_header')
    <h1 class="text-2xl font-semibold">Editar Usuario</h1>
@endsection

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <div class="mb-4">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

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
                    <label class="block text-gray-700 font-semibold">Nueva Contraseña (opcional)</label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                    <small class="text-gray-500">Dejar en blanco para mantener la actual.</small>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Rol</label>
                    <select name="rol_id" class="form-control" required>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}" {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                                {{ ucfirst($rol->descripcion) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
@endsection