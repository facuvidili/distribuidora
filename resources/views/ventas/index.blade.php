@extends('layouts.app')

@section('title', 'Gestión de Ventas')
@section('breadcrumb')
    <li class="breadcrumb-item active">Ventas Realizadas</li>
@endsection
@section('content_header')
    <h1>Gestión de Ventas</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('ventas.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Nueva Venta
            </a>
            <!-- Botón para generar el reporte de ventas con gráficos -->
            <a href="{{ route('ventas.reporte') }}" class="btn btn-info" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-chart-line"></i> Generar Reporte de Ventas
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="ventas-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->cliente->nombre ?? 'Sin asignar' }}</td>
                                <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d-m-Y H:i:s') }}</td>
                                <td>${{ number_format($venta->total, 2) }}</td>
                                <td>
                                    <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> <span>Ver</span>
                                    </a>
                                    @if (auth()->user()->rol->descripcion === 'Administrador')
                                        <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> <span>Editar</span>
                                        </a>
                                        <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm eliminarVenta"
                                                data-id="{{ $venta->id }}">
                                                <i class="fas fa-trash-alt"></i> <span>Eliminar</span>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#ventas-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });

        document.querySelectorAll('.eliminarVenta').forEach(button => {
            button.addEventListener('click', function() {
                let ventaId = this.dataset.id;

                Swal.fire({
                    title: "¿Eliminar esta venta?",
                    text: "Esta acción no se puede deshacer",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/ventas/${ventaId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(() => {
                                Swal.fire({
                                    title: "Eliminado",
                                    text: "La venta ha sido eliminada correctamente.",
                                    icon: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            })
                            .catch(() => Swal.fire("Error",
                                "Hubo un problema al eliminar la venta.", "error"));
                    }
                });
            });
        });
    </script>
@endsection
