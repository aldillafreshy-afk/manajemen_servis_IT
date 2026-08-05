<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanTeknisi extends Model
{
    use HasFactory;

    protected $table = 'penugasan_teknisis';

    protected $fillable = [
        'laporan_id',
        'teknisi_id',
        'tanggal_penugasan',
        'status_penugasan',
        'catatan_admin',
    ];

    // Relasi ke Laporan Kerusakan
    public function laporan()
    {
        return $this->belongsTo(LaporanKerusakan::class, 'laporan_id');
    }

    // Relasi ke User (Teknisi)
    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }
}