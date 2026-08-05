<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;

    protected $table = 'perangkats';

    protected $fillable = [
        'kode_perangkat',
        'nama_perangkat',
        'jenis_perangkat',
        'merk',
        'ruangan_id',
        'tahun_pembelian',
        'status',
    ];

    // Relasi: Setiap Perangkat dimiliki oleh 1 Ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}