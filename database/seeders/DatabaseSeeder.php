<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Utilisateur::create([
            'nom' => 'Ramdani',
            'prenom' => 'Mehdi',
            'email' => 'admin@',
            'password' => 'admin@',
            'tele' => '0680986736',
            'role' => 'admin',
            'image' => null
        ]);
    }
}
