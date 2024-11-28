<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::create([
            'name' => 'Jean',
            'email' => '1@gmail.com',
            'password' => Hash::make('12345678'), // Contraseña encriptada
            'role' => User::ROLE_ADMIN, // Rol asignado como administrador
        ]);
}
}
