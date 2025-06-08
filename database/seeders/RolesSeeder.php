<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class UsersSeeder extends Seeder
{
    public function run()
    {
        Rol::create([
            'descripcion' => 'Administrador',
        ]);
        Rol::create([
            'descripcion' => 'Vendedor',
        ]);
        
    }
}