<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisKerusakan;

class JenisKerusakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
        [
            'nama_kerusakan' => 'Hardware',
        ],
        [
            'nama_kerusakan' => 'Software',
        ],
        [
            'nama_kerusakan' => 'Jaringan',
        ],
    ];
    foreach ($data as $item){
            JenisKerusakan::create($item);
        }
    }
}
