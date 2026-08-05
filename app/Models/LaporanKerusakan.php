<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kerusakans';

    protected $fillable = [
        'user_id',
        'perangkat_id',
        'ruangan_id',
        'jenis_kerusakan_id',
        'deskripsi_kerusakan',
        'foto',
        'tingkat_urgensi',
        'status',
        'tanggal_lapor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class, 'perangkat_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function jenisKerusakan()
    {
        return $this->belongsTo(JenisKerusakan::class, 'jenis_kerusakan_id');
    }
}