<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('rol_id')->constrained('roles')->onDelete('cascade'); // Relación con la tabla roles
            $table->boolean('activo')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Crear usuario administrador
        User::create([
            'name' => 'Facundo Vidili',
            'email' => 'facuvidili@gmail.com',
            'password' => Hash::make('12345678'),
            'rol_id' => 1, // Asegurate de que este ID corresponda al rol de administrador
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
