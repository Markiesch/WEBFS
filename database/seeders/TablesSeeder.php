<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TablesSeeder extends Seeder
{
    public function run()
    {
        $table = [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for ($i = 0; $i < 30; $i++) {
            Table::create($table);
        }
    }
}
