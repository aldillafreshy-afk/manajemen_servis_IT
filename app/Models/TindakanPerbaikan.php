<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakanPerbaikan extends Model
{
    use HasFactory;

    protected $table = 'tindakan_perbaikans';

    protected $fillable = [
        'penugasan_id',
        'deskripsi_tindakan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_hasil',
        'biaya',
        'catatan_teknisi',
    ];

    // Relasi ke Penugasan Teknisi
    public function penugasan()
    {
        return $this->belongsTo(PenugasanTeknisi::class, 'penugasan_id');
    }
}