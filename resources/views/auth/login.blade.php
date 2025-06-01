<x-guest-layout class="login-page">
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('/ruta-de-tu-imagen.jpg');">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="login-box">
                <div class="card card-outline card-primary shadow-lg rounded-lg">
                    <div class="card-header text-center">
                        <h1 href="#" class="h1 text-primary font-weight-bold">
                            <i class="fas fa-store"></i> <span class="">Sistema de Ventas</span>  
                            <span class="text-success">Distribuidora</span>
                        </h1>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg text-xl font-semibold text-gray-700 dark:text-white">
                            🔑 Inicio de Sesión
                        </p>

                        <x-auth-session-status :status="$errors->first('failure')" />

                        <x-forms.input type="email" label="📧 Email" name="email" placeholder="Ingrese su email" />
                        <x-forms.input type="password" label="🔒 Password" name="password" placeholder="Ingrese su password" />

                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">
                                        Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center justify-center">
                            <div class="col-8 m-2">
                                <button type="submit" class="btn btn-lg btn-primary btn-block rounded-full shadow-md">
                                    Iniciar sesión
                                </button>
                            </div>
                        </div>

                        <p class="mt-4 text-center text-sm">
                            <a href="{{ route('password.request') }}" class="text-red-500 hover:text-red-700">
                                Olvidé mi contraseña
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>