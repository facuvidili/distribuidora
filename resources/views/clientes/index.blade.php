@extends('layouts.app')

@section('title', 'Gestión de Clientes')
@section('breadcrumb')
    <li class="breadcrumb-item active">Clientes</li>
@endsection
@section('content_header')
    <h1>Gestión de Clientes</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('clientes.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Nuevo Cliente
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="clientes-table" class="table table-striped data-table">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->dni }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>{{ $cliente->direccion }}</td>
                                <td>
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> <span>Editar</span>
                                    </a>
                                    @if (auth()->user()->rol->descripcion === 'Administrador')
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm eliminarCliente"
                                                data-id="{{ $cliente->id }}">
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
@vite('resources/js/datatable.js')
@section('js')
    <script>
        document.querySelectorAll('.eliminarCliente').forEach(button => {
            button.addEventListener('click', function() {
                let clienteId = this.dataset.id;

                Swal.fire({
                    title: "¿Eliminar este cliente?",
                    text: "Esta acción no se puede deshacer",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/clientes/${clienteId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(() => {
                                Swal.fire({
                                    title: "Eliminado",
                                    text: "El cliente ha sido eliminado correctamente.",
                                    icon: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            })
                            .catch(() => Swal.fire("Error",
                                "Hubo un problema al eliminar el cliente.", "error"));
                    }
                });
            });
        });
    </script>
@endsection
