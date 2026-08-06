<?php

namespace App\Http\Controllers;

use App\Models\LaporanKerusakan;
use App\Models\TindakanPerbaikan;
use App\Models\RiwayatStatus;
use App\Models\PenugasanTeknisi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPdfController extends Controller
{
    /**
     * Generate PDF dan download
     */
    public function generatePdf($id)
    {
        // Ambil data laporan dengan relasi
        $laporan = LaporanKerusakan::with([
            'user', 
            'perangkat', 
            'ruangan', 
            'jenisKerusakan',
            'penugasanTeknisi.teknisi',
            'penugasanTeknisi.tindakanPerbaikan' // ← SEKARANG SUDAH BISA!
        ])->findOrFail($id);

        // Cek apakah user memiliki akses
        $user = Auth::user();
        $roleUser = $user->role;
        $roleName = strtolower(is_object($roleUser) ? ($roleUser->nama ?? '') : ($roleUser ?? ''));

        // Admin bisa semua, teknisi hanya laporan yang ditugaskan, user hanya laporan sendiri
        if ($roleName === 'teknisi') {
            $isAssigned = $laporan->penugasanTeknisi->contains('teknisi_id', $user->id);
            if (!$isAssigned) {
                abort(403, 'Anda tidak memiliki akses ke laporan ini.');
            }
        } elseif ($roleName !== 'admin' && $laporan->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        // Ambil riwayat status
        $riwayatStatus = RiwayatStatus::where('laporan_id', $laporan->id)
            ->with('user')
            ->latest()
            ->get();

        // Data untuk PDF
        $data = [
            'laporan' => $laporan,
            'riwayatStatus' => $riwayatStatus,
            'tanggal_cetak' => now()->format('d-m-Y H:i:s'),
            'dicetak_oleh' => Auth::user()->name,
        ];

        // Load view PDF
        $pdf = Pdf::loadView('pdf.laporan', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Laporan-Kerusakan-'.$laporan->no_laporan.'.pdf');
    }

    /**
     * Stream PDF untuk preview
     */
    public function streamPdf($id)
    {
        $laporan = LaporanKerusakan::with([
            'user', 
            'perangkat', 
            'ruangan', 
            'jenisKerusakan',
            'penugasanTeknisi.teknisi',
            'penugasanTeknisi.tindakanPerbaikan'
        ])->findOrFail($id);

        $user = Auth::user();
        $roleUser = $user->role;
        $roleName = strtolower(is_object($roleUser) ? ($roleUser->nama ?? '') : ($roleUser ?? ''));

        if ($roleName === 'teknisi') {
            $isAssigned = $laporan->penugasanTeknisi->contains('teknisi_id', $user->id);
            if (!$isAssigned) {
                abort(403, 'Anda tidak memiliki akses ke laporan ini.');
            }
        } elseif ($roleName !== 'admin' && $laporan->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        $riwayatStatus = RiwayatStatus::where('laporan_id', $laporan->id)
            ->with('user')
            ->latest()
            ->get();

        $data = [
            'laporan' => $laporan,
            'riwayatStatus' => $riwayatStatus,
            'tanggal_cetak' => now()->format('d-m-Y H:i:s'),
            'dicetak_oleh' => Auth::user()->name,
        ];

        $pdf = Pdf::loadView('pdf.laporan', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('Laporan-Kerusakan-'.$laporan->no_laporan.'.pdf');
    }
}