<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'app@wizionar.com',
            'password' => bcrypt('lozinka2024'),
            'user_type' => 'administrator', // Pretpostavljajući da koristite 'user_type' za razlikovanje uloga
        ]);
    }
}
