<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
             @csrf
        </form>


        <a href="#" onclick="event.preventDefault(); confirmarLogout();" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>


                
    </ul>
</nav>
@push('js')
<script>
    function confirmarLogout() {
        Swal.fire({
            title: '¿Seguro que quieres cerrar sesión?',
            text: "Se cerrará tu cuenta actual.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, cerrar sesión'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
@endpush
