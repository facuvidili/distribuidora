@extends('layouts.app')

@section('title', 'Editar Datos de la Empresa')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('empresa.show', ['empresa' => $empresa->id]) }}">Empresa</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection
@section('content_header')
    <h1 class="text-2xl font-semibold">Editar Datos de la Empresa</h1>
@endsection

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">

        <div class="mb-4">
            <a href="{{ route('empresa.show', ['empresa' => $empresa->id]) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a la empresa
            </a>
        </div>

        <form method="POST" action="{{ route('empresa.update', $empresa->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="d-flex flex-column align-items-center mb-4">
                <label for="logoInput" class="cursor-pointer">
                    <img id="logoPreview" src="{{ asset($empresa->logo ?? asset('dist/img/default_logo.jpg')) }}"
                        alt="Logo de la empresa" class="img-thumbnail rounded shadow-lg"
                        style="width: 150px; height: 150px; object-fit: contain;">
                </label>
                <input type="file" id="logoInput" name="logo" class="d-none" accept="image/*">

                <button type="button" id="changeLogoBtn" class="btn btn-primary mt-2">
                    <i class="fas fa-image"></i> Cambiar Imagen
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nombre" class="block text-gray-700 font-semibold">Nombre de la Empresa</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $empresa->nombre) }}"
                        class="form-control" required>
                </div>

                <div>
                    <label for="direccion" class="block text-gray-700 font-semibold">Dirección</label>
                    <input type="text" name="direccion" id="direccion"
                        value="{{ old('direccion', $empresa->direccion) }}" class="form-control" required>
                </div>

                <div>
                    <label for="telefono" class="block text-gray-700 font-semibold">Teléfono</label>
                    <input type="number" name="telefono" id="telefono" value="{{ old('telefono', $empresa->telefono) }}"
                        class="form-control" required max="99999999999999999999">
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-semibold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $empresa->email) }}"
                        class="form-control" required>
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check-circle"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        document.getElementById('logoInput').addEventListener('change', function(event) {
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('logoPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('changeLogoBtn').addEventListener('click', function() {
            document.getElementById('logoInput').click(); // Abre el selector de archivos
        });
    </script>

@endsection
