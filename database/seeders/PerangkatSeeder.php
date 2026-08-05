<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perangkat;

class PerangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Perangkat::create([
            'kode_perangkat' => 'PC-001',
            'nama_perangkat' => 'Komputer 1',
            'jenis_perangkat' => 'PC',
            'merk' => 'Zyrex',
            'ruangan_id' => 1,
            'tahun_pembelian' => now(),
            'status' => 'aktif',
        ]);
    }
}
