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

    // ===== TAMBAHKAN RELASI INI =====
    /**
     * Relasi ke Penugasan Teknisi
     * Satu laporan bisa memiliki banyak penugasan
     */
    public function penugasanTeknisi()
    {
        return $this->hasMany(PenugasanTeknisi::class, 'laporan_id');
    }

    /**
     * Relasi ke Tindakan Perbaikan melalui Penugasan
     * Mengambil semua tindakan perbaikan dari semua penugasan laporan ini
     */
    public function tindakanPerbaikan()
    {
        return $this->hasManyThrough(
            TindakanPerbaikan::class,
            PenugasanTeknisi::class,
            'laporan_id', // Foreign key di penugasan_teknisis
            'penugasan_id', // Foreign key di tindakan_perbaikans
            'id', // Local key di laporan_kerusakans
            'id' // Local key di penugasan_teknisis
        );
    }

    
}