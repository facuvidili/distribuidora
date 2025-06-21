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
                <table id="users-table" class="table table-striped data-table">
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
                                    <a href="{{ route('user.edit', $user->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>
                                        <span>Editar</span></a>
                                    @if (auth()->user()->id !== $user->id)
                                        <form action="{{ route('user.cambiar-estado', $user->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('POST')
                                            <button type="button"
                                                class="btn btn-sm {{ $user->activo == 1 ? 'btn-danger' : 'btn-success' }} cambiarEstado"
                                                data-id="{{ $user->id }}"
                                                data-estado="{{ $user->activo == 1 ? 'activo' : 'inactivo' }}">
                                                <i class="fas {{ $user->activo == 1 ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                                <span>{{ $user->activo ? 'Desactivar' : 'Activar' }}</span>
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
        document.querySelectorAll('.cambiarEstado').forEach(button => {
            button.addEventListener('click', function() {
                let userId = this.dataset.id;
                let estadoActual = this.dataset.estado;
                let nuevoEstado = estadoActual === 'activo' ? 'inactivo' : 'activo';
                let accion2 = estadoActual === 'activo' ? 'desactivado' : 'activado';

                let accion = nuevoEstado === 'activo' ? 'Activar' : 'Desactivar';

                Swal.fire({
                    title: `¿${accion} este usuario?`,
                    text: `El usuario será ${accion2}.`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: `Sí, ${accion}`,
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/user/${userId}/cambiar-estado`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    estado: nuevoEstado
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: "Actualizado",
                                        text: `El usuario ahora está ${nuevoEstado}.`,
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(() => {
                                        location.reload(); // Recarga la página para reflejar el cambio
                                    });

                                    // Cambia el botón dinámicamente sin recargar
                                    this.dataset.estado = nuevoEstado;
                                }
                            })
                            .catch(error => {
                                console.error("Error en la petición:",
                                error); // Muestra el error en la consola
                                Swal.fire("Error",
                                    `Hubo un problema al cambiar el estado. Detalles: ${error.message}`,
                                    "error");
                            });

                    }
                });
            });
        });
    </script>
@endsection
