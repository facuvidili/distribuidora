@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') == 'passwords.sent' ? 'Hemos enviado un enlace para restablecer tu contraseña a tu correo electrónico.' : session('status') }}
    </div>
@endif

<x-guest-layout class="login-page">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1">{{ 'Sistema de Ventas' }}</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Olvidaste tu contraseña? Aquí puedes solicitar un cambio de contraseña facilmente.</p>
            <form action="{{ route('password.email') }}" method="post">
                @csrf
                <x-forms.input type="email" label="Email" name="email" placeholder="Ingrese su email" />
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Requerir nueva contraseña</button>
                    </div>
                </div>
            </form>
            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">Inicio de sesión</a>
            </p>
        </div>
    </div>
</x-guest-layout>
