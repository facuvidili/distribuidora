<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        // Insertar empresa por defecto
        DB::table('empresa')->insert([
            'nombre' => 'Distribuidora Genérica S.A.',
            'direccion' => 'Av. Siempre Viva 123',
            'telefono' => '1234-5678',
            'email' => 'contacto@empresa.com',
            'logo' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
