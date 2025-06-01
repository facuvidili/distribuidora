@extends('layouts.app')

@section('title', 'Detalle de Venta')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
    <li class="breadcrumb-item active">Ver Venta</li>
@endsection
@section('content')
    <div class="container mx-auto p-4 bg-white rounded-lg shadow-md">
        <div class="mb-4">
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
        <h1 class="text-2xl font-semibold">Venta #{{ $venta->id }}</h1>
        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'Sin asignar' }}</p>
        <p><strong>Fecha:</strong> {{ $venta->fecha_venta }}</p>
        <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>

        <h2 class="text-xl font-semibold mt-4">Productos Comprados</h2>
        <ul class="list-disc pl-6">
            @foreach ($venta->productos as $producto)
                <li>{{ $producto->nombre }} - {{ $producto->pivot['cantidad'] }} unidades -
                    ${{ number_format($producto->pivot['importe'], 2) }}</li>
            @endforeach
        </ul>
    </div>
@endsection
