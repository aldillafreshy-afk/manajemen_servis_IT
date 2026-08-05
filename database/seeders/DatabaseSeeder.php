<?php

namespace Database\Seeders;

use App\Models\JenisKerusakan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            RuanganSeeder::class,
            PerangkatSeeder::class,
            JenisKerusakanSeeder::class,
        ]);
    }
}