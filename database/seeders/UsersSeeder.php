<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'rol_id' => 1,
            'activo' => true,
        ]);

        User::create([
            'name' => 'Vendedor2',
            'email' => 'vendedor2@example.com',
            'password' => Hash::make('vendedor123'),
            'rol_id' => 2,
            'activo' => true,
        ]);

        User::create([
            'name' => 'Vendedor3',
            'email' => 'vendedor3@example.com',
            'password' => Hash::make('vendedor4123'),
            'rol_id' => 2,
            'activo' => true,
        ]);
    }
}