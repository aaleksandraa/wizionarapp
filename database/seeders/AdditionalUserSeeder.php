<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdditionalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Nevena Marjanović',
            'email' => 'nevena@crystalnailsbih.com',
            'password' => bcrypt('!daprovjerimstotke!'),
            'user_type' => 'administrator', 
        ]);

        
    }
}
