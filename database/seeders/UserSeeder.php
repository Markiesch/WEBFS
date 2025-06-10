<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@goudendraak.nl',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Medewerker',
            'email' => 'medewerker@goudendraak.nl',
            'password' => bcrypt('password'),
        ]);
    }
}
