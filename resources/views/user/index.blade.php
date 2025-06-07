@extends('layouts.app')

@section('title', 'Gestión de Usuarios')
@section('breadcrumb')
    <li class="breadcrumb-item active">Usuarios</li>
@endsection
@section('content_header')
    <h1>Gestión de Usuarios</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href=" {{ route('user.create') }}" class="btn btn-success"><i class="fas fa-user-plus"></i> Agregar Usuario</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->rol ? ucfirst($user->rol->descripcion) : 'Sin rol' }}</td>
                                <td>
                                    <span class="badge {{ $user->activo ? 'badge-success' : 'badge-danger' }}">
                                        {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> <span>Editar</span></a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm eliminarUser"
                                            data-id="{{ $user->id }}">
                                            <i class="fas fa-trash-alt"> </i> <span>Eliminar</span>
                                        </button>
                                    </form>
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
            $('#users-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });

        document.querySelectorAll('.eliminarUser').forEach(button => {
            button.addEventListener('click', function() {
                let userId = this.dataset.id;

                Swal.fire({
                    title: "¿Eliminar este usuario?",
                    text: "Esta acción no se puede deshacer",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/user/${userId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(() => {
                                Swal.fire({
                                    title: "Eliminado",
                                    text: "El usuario ha sido eliminado correctamente.",
                                    icon: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            })
                            .catch(() => Swal.fire("Error",
                                "Hubo un problema al eliminar el usuario.", "error"));
                    }
                });
            });
        });
    </script>
@endsection
