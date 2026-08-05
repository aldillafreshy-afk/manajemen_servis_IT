<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    use HasFactory;

    protected $table = 'riwayat_statuses';

    protected $fillable = [
        'laporan_id',
        'user_id',
        'status_lama',
        'status_baru',
        'keterangan',
    ];

    // Relasi ke Laporan Kerusakan
    public function laporan()
    {
        return $this->belongsTo(LaporanKerusakan::class, 'laporan_id');
    }

    // Relasi ke User yang mengubah status
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
