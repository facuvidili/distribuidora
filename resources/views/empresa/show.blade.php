@extends('layouts.app')

@section('title', 'Datos de la Empresa')
@section('breadcrumb')
    <li class="breadcrumb-item active">Empresa</li>
@endsection

@section('content_header')
    <h1 class="text-2xl font-semibold">Datos de la Empresa</h1>
@endsection

@section('content')
    @if ($empresa)
        <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
            <div class="text-center mb-4">
                <img src="{{ asset($empresa->logo ?? asset('dist/img/default_logo.jpg')) }}" alt="Logo de la empresa"
                    class="img-thumbnail rounded shadow-lg" style="width: 150px; height: 150px; object-fit: contain;">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre:</label>
                <p class="text-lg font-semibold">{{ $empresa->nombre }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Dirección:</label>
                <p class="text-lg">{{ $empresa->direccion }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Teléfono:</label>
                <p class="text-lg">{{ $empresa->telefono }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email:</label>
                <p class="text-lg">{{ $empresa->email }}</p>
            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('empresa.edit', ['empresa' => $empresa->id]) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Datos
                </a>
                <button onclick="imprimirTarjetas()" class="btn btn-info">
                    <i class="fas fa-print"></i> Imprimir Tarjetas
                </button>
            </div>

            <div id="tarjetas" style="display: none;">
                <div id="tarjetas-contenedor" style="width: 100%; height: 100%; display: table;">
                    <div class="tarjeta-row" style="display: table-row; columns: 2;">
                        @for ($i = 0; $i < 8; $i++)
                            <div class="tarjeta-empresa"
                                style="
                                                    display: table-cell; 
                                                    width: 50%; 
                                                    border: 2px solid #1c2833; 
                                                    border-radius: 8px;
                                                    padding: 15px; 
                                                    font-size: 14px; 
                                                    text-align: center; 
                                                    page-break-inside: avoid; 
                                                    vertical-align: top;
                                                    background: #ecefea;
                                                    box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
                                                    font-family: 'Arial', sans-serif;">

                                <img src="{{ asset($empresa->logo ?? asset('dist/img/default_logo.jpg')) }}" alt="Logo Empresa" class="logo"
                                    style="
                                        width: 60px; 
                                        height: 60px; 
                                        border-radius: 50%; 
                                        margin-bottom: 10px;">

                                <h2 class="nombre"
                                    style="
                                        color: #17202a; 
                                        font-weight: bold; 
                                        margin: 5px 0;
                                        font-size: 20px;
                                        font-family: 'Georgia', serif;">
                                    {{ $empresa->nombre }}</h2>

                                <hr style="width: 80%; border-top: 1px solid #bbb;">

                                <p
                                    style="color: #2c3e50; margin: 8px 0; font-weight: 500; font-family: 'Verdana', sans-serif;">
                                    <i class="fas fa-map-marker-alt"></i> {{ $empresa->direccion }}
                                </p>
                                <p
                                    style="color: #2c3e50; margin: 8px 0; font-weight: 500; font-family: 'Verdana', sans-serif;">
                                    <i class="fas fa-phone"></i> {{ $empresa->telefono }}
                                </p>
                                <p
                                    style="color: #2c3e50; margin: 8px 0; font-weight: 500; font-family: 'Verdana', sans-serif;">
                                    <i class="fas fa-envelope"></i> {{ $empresa->email }}
                                </p>

                                <hr style="width: 80%; border-top: 1px solid #bbb;">

                                <p class="slogan"
                                    style="
                        color: #1c2833; 
                        font-style: italic; 
                        font-size: 13px; 
                        margin-top: 10px;
                        font-family: 'Times New Roman', serif;">
                                    "Compromiso y calidad en cada paso."</p>
                            </div>

                            @if ($i % 2 == 1)
                    </div>
                    <div class="tarjeta-row" style="display: table-row; columns: 2;">
    @endif
    @endfor
    </div>
    </div>
    </div>
@else
    <p class="text-lg font-semibold text-red-600">No hay datos de la empresa registrados.</p>
    <div class="text-right">
        <a href="{{ route('empresa.create') }}" class="btn btn-warning">Registrar Empresa</a>
    </div>
    @endif
@endsection

@section('js')
    <script>
        function imprimirTarjetas() {
            var contenido = document.getElementById("tarjetas").innerHTML;
            var ventana = window.open('', '', 'width=800,height=600');
            ventana.document.write('<html><head><title>Tarjetas de Empresa</title>');
            ventana.document.write('</head><body>');
            ventana.document.write('<div id="tarjetas-contenedor">' + contenido + '</div>');
            ventana.document.write('</body></html>');
            ventana.document.close();
            ventana.print();
        }
    </script>
@endsection
