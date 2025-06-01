<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <label for="password">Nueva Contraseña:</label>
    <input type="password" name="password" required minlength="8">
    
    <label for="password_confirmation">Confirmar Contraseña:</label>
    <input type="password" name="password_confirmation" required>
    
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cambiar Contraseña</button>
</form>
