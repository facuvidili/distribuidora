@extends('layouts.app')

@section('title', 'Gestión de Productos')

@section('content_header')
    <h1>Gestión de Productos</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('productos.create') }}" class="btn btn-success">
            <i class="fas fa-box"></i> Nuevo Producto
        </a>
    </div>
    <div class="card-body">
        <table id="productos-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>
                        @if ($producto->proveedor)
                            {{ $producto->proveedor->razon_social }}
                        @else
                            <span class="text-gray-500">No asignado</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm eliminarProducto" data-id="{{ $producto->id }}">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#productos-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });
    });

    document.querySelectorAll('.eliminarProducto').forEach(button => {
        button.addEventListener('click', function() {
            let productoId = this.dataset.id;

            Swal.fire({
                title: "¿Eliminar este producto?",
                text: "Esta acción no se puede deshacer",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/productos/${productoId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(() => {
                            Swal.fire({
                                title: "Eliminado",
                                text: "El producto ha sido eliminado correctamente.",
                                icon: "success",
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        })
                        .catch(() => Swal.fire("Error",
                            "Hubo un problema al eliminar el producto.", "error"));
                }
            });
        });
    });
</script>
@endsection