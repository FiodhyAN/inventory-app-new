<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //create admin and superadmin
        User::create([
            'nama' => 'Superadmin',
            'username' => 'superadmin',
            'password' => bcrypt('superadmin'),
            'is_admin' => true,
            'is_superadmin' => true,
        ]);
        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'is_admin' => true,
            'is_superadmin' => false,
        ]);
    }
}