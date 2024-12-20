<?php

namespace Database\Seeders;
//use App\Models\Task;

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
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Contraseña encriptada
            'role' => User::ROLE_ADMIN, // Rol asignado como administrador
        ]);
        //Task::factory(50)->create();
}
}
