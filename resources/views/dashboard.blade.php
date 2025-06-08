@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')


    <h2 class="text-2xl font-bold leading-tight mb-2 text-gray-800">
        Sistema de Gestión de Distribuidora de Productos
    </h2>
    <hr class="mb-6 border-gray-300">

    <!-- Tarjetas de Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Tarjeta de Ventas -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-blue-500">
            <div>
                <h4 class="text-lg font-semibold text-gray-700">Ventas Realizadas</h4>
                <p class="text-2xl font-bold text-blue-500">{{ $ventasCount }}</p>
                <small class="text-gray-500">Últimos 30 días</small>
            </div>
            <i class="fas fa-shopping-cart text-4xl text-blue-500"></i>
        </div>

        <!-- Tarjeta de Clientes -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-green-500">
            <div>
                <h4 class="text-lg font-semibold text-gray-700">Clientes Registrados</h4>
                <p class="text-2xl font-bold text-green-500">{{ $clientesCount }}</p>
                <small class="text-gray-500">En total</small>
            </div>
            <i class="fas fa-users text-4xl text-green-500"></i>
        </div>

        <!-- Tarjeta de Proveedores -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-yellow-500">
            <div>
                <h4 class="text-lg font-semibold text-gray-700">Proveedores Activos</h4>
                <p class="text-2xl font-bold text-yellow-500">{{ $proveedoresCount }}</p>
                <small class="text-gray-500">Colaboradores comerciales</small>
            </div>
            <i class="fas fa-truck text-4xl text-yellow-500"></i>
        </div>

        <!-- Tarjeta de Balance -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-indigo-500">
            <div>
                <h4 class="text-lg font-semibold text-gray-700">Balance General</h4>
                <p class="text-2xl font-bold text-indigo-500">${{ $balanceGeneral }}</p>
                <small class="text-gray-500">Última actualización</small>
            </div>
            <i class="fas fa-chart-line text-4xl text-indigo-500"></i>
        </div>
    </div>

    <!-- Tabla de Últimas Ventas -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Últimas Ventas</h3>
        <div class="table-responsive mb-4">
            <table class="table-auto w-full text-left bg-white rounded-lg overflow-hidden shadow-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                        <th class="px-4 py-2">Número</th>
                        <th class="px-4 py-2">Cliente</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ultimasVentas as $venta)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $venta->id }}</td>
                            <td class="px-4 py-2">{{ $venta->cliente->nombre ?? 'Sin asignar' }}</td>
                            <td class="px-4 py-2">{{ $venta->fecha_venta }}</td>
                            <td class="px-4 py-2 text-right">${{ number_format($venta->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
