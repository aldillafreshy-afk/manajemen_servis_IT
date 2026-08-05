<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ruangan::insert(
        [
            'kode_ruangan' => 'LAB-1',
            'nama_ruangan' => 'Laboratorium komputer 1'
        ],
        [
            'kode_ruangan' => 'LAB-2',
            'nama_ruangan' => 'Laboratorium komputer 3'
        ],
        [
            'kode_ruangan' => 'TU-1',
            'nama_ruangan' => 'Tata Usaha 1'
        ]);
    }
}
