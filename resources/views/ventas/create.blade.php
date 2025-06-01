@extends('layouts.app')

@section('title', 'Registrar Venta')
@section('breadcrumb')
    <li class="breadcrumb-item active">Registrar Venta</li>
@endsection
@section('content_header')
    <h1 class="text-2xl font-semibold">Registrar Nueva Venta</h1>
@endsection

@section('content')
    <div class="container mx-auto p-4 bg-white rounded-lg shadow-md">
        <form method="POST" action="{{ route('ventas.store') }}">
            @csrf

            <!-- Selección de Cliente -->
            <div class="mb-4 col-4">
                <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
                <select id="cliente" name="cliente_id" class="form-select w-full mt-1 px-3 py-2 border rounded-md">
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Selección de Productos -->
            <div class="flex items-center mb-2">
                <label for="productos" class="block text-sm font-medium text-gray-700">Productos</label>
                <button type="button" id="agregarProducto" class="btn btn-primary" style="margin-left: 14em;">
                    <i class="fas fa-plus"></i>Agregar Producto
                </button>
            </div>
            <div id="productos-container" class="space-y-2">
                <div class="flex space-x-2">
                    <select name="productos[]" class="form-select w-3/5 px-3 py-2 border rounded-md">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                                {{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="cantidad[]" placeholder="Cantidad"
                        class="w-1/5 px-3 py-2 border rounded-md text-center" min="1" required>
                    <button type="button" class="btn btn-danger btn-sm px-3 py-2">X</button>
                </div>
            </div>
            <hr>
            <!-- Total de Venta -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Total:</label>
                <span id="totalVenta" class="text-lg font-semibold">$0.00</span>
            </div>

            <!-- Botón de Confirmación -->
            <div class="text-right">
                <button type="submit" class="btn btn-success">Registrar Venta</button>
            </div>


        </form>
    </div>
@endsection
@section('js')
    <script>
        document.getElementById('agregarProducto').addEventListener('click', function() {
            let container = document.getElementById('productos-container');

            let nuevoProducto = document.createElement('div');
            nuevoProducto.classList.add('flex', 'space-x-2');

            nuevoProducto.innerHTML = `
            <select name="productos[]" class="form-select w-3/5 px-3 py-2 border rounded-md">
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                        {{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}
                    </option>
                @endforeach
            </select>
            <input type="number" name="cantidad[]" placeholder="Cantidad" class="w-1/5 px-3 py-2 border rounded-md text-center">
            <button type="button" class="btn btn-danger btn-sm px-3 py-2 remove-product">X</button>
        `;

            container.appendChild(nuevoProducto);
        });

        // ✅ Evento para eliminar producto al hacer clic en "X"
        document.getElementById('productos-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-product')) {
                event.target.parentElement.remove();
                actualizarTotal();
            }
        });

        // ✅ Actualización dinámica del total de la venta
        document.getElementById('productos-container').addEventListener('input', function() {
            actualizarTotal();
        });

        function actualizarTotal() {
            let total = 0;
            document.querySelectorAll('[name="productos[]"]').forEach((select, index) => {
                let precio = select.selectedOptions[0].dataset.precio || 0;
                let cantidad = document.querySelectorAll('[name="cantidad[]"]')[index].value || 0;
                total += precio * cantidad;
            });
            document.getElementById('totalVenta').innerText = `$${total.toFixed(2)}`;
        }
    </script>
@endsection
