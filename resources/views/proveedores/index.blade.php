@extends('layouts.app')

@section('title', 'Gestión de Proveedores')
@section('breadcrumb')
    <li class="breadcrumb-item active">Proveedores</li>
@endsection
@section('content_header')
    <h1>Gestión de Proveedores</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('proveedores.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Nuevo Proveedor
            </a>
        </div>
        <div class="card-body">
            <table id="proveedores-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Razón Social</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->dni }}</td>
                            <td>{{ $proveedor->razon_social }}</td>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->direccion }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>
                                <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"> </i> Editar
                                </a>
                                @if (auth()->user()->rol->descripcion === 'Administrador')
                                    <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm eliminarProveedor"
                                            data-id="{{ $proveedor->id }}">
                                            <i class="fas fa-trash-alt"> </i> Eliminar
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#proveedores-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });

        document.querySelectorAll('.eliminarProveedor').forEach(button => {
            button.addEventListener('click', function() {
                let proveedorId = this.dataset.id;

                Swal.fire({
                    title: "¿Eliminar este proveedor?",
                    text: "Esta acción no se puede deshacer",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/proveedores/${proveedorId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(() => {
                                Swal.fire({
                                    title: "Eliminado",
                                    text: "El proveedor ha sido eliminado correctamente.",
                                    icon: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            })
                            .catch(() => Swal.fire("Error",
                                "Hubo un problema al eliminar el proveedor.", "error"));
                    }
                });
            });
        });
    </script>
@endsection
