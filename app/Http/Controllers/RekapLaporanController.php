<?php

namespace App\Http\Controllers;

use App\Models\LaporanKerusakan;
use App\Models\Perangkat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapLaporanController extends Controller
{
    /**
     * Halaman rekap laporan
     */
    public function index(Request $request)
    {
        // Filter berdasarkan tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $perangkatId = $request->input('perangkat_id');

        $query = LaporanKerusakan::with(['user', 'perangkat', 'ruangan', 'jenisKerusakan']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($perangkatId) {
            $query->where('perangkat_id', $perangkatId);
        }

        $laporans = $query->latest()->paginate(10);
        $perangkatList = Perangkat::all();
        $statusList = ['menunggu', 'diproses', 'selesai', 'ditugaskan'];

        return view('rekap.index', compact('laporans', 'perangkatList', 'statusList', 'startDate', 'endDate', 'status', 'perangkatId'));
    }

    /**
     * Generate PDF Rekap Laporan - DOWNLOAD
     */
    public function generatePdf(Request $request)
    {
        // Ambil parameter filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $perangkatId = $request->input('perangkat_id');

        $query = LaporanKerusakan::with(['user', 'perangkat', 'ruangan', 'jenisKerusakan', 'penugasanTeknisi.teknisi']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($perangkatId) {
            $query->where('perangkat_id', $perangkatId);
        }

        $laporans = $query->latest()->get();

        // Data statistik
        $totalLaporan = $laporans->count();
        $totalSelesai = $laporans->where('status', 'selesai')->count();
        $totalDiproses = $laporans->where('status', 'diproses')->count();
        $totalMenunggu = $laporans->where('status', 'menunggu')->count();

        // Data untuk grafik (jika diperlukan)
        $statusCount = [
            'selesai' => $totalSelesai,
            'diproses' => $totalDiproses,
            'menunggu' => $totalMenunggu,
        ];

        $data = [
            'laporans' => $laporans,
            'totalLaporan' => $totalLaporan,
            'totalSelesai' => $totalSelesai,
            'totalDiproses' => $totalDiproses,
            'totalMenunggu' => $totalMenunggu,
            'statusCount' => $statusCount,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'perangkatId' => $perangkatId,
            'tanggal_cetak' => now()->format('d-m-Y H:i:s'),
            'dicetak_oleh' => Auth::user()->name,
            'periode' => $this->getPeriodeText($startDate, $endDate),
        ];

        $pdf = Pdf::loadView('pdf.rekap-laporan', $data);
        
        // ===== PERBAIKAN: Ubah ke PORTRAIT =====
        $pdf->setPaper('A4', 'portrait'); // ← Ubah dari landscape ke portrait

        return $pdf->download('Rekap-Laporan-Kerusakan-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Stream PDF untuk preview - PORTRAIT
     */
    public function streamPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $perangkatId = $request->input('perangkat_id');

        $query = LaporanKerusakan::with(['user', 'perangkat', 'ruangan', 'jenisKerusakan', 'penugasanTeknisi.teknisi']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($perangkatId) {
            $query->where('perangkat_id', $perangkatId);
        }

        $laporans = $query->latest()->get();

        $totalLaporan = $laporans->count();
        $totalSelesai = $laporans->where('status', 'selesai')->count();
        $totalDiproses = $laporans->where('status', 'diproses')->count();
        $totalMenunggu = $laporans->where('status', 'menunggu')->count();

        $data = [
            'laporans' => $laporans,
            'totalLaporan' => $totalLaporan,
            'totalSelesai' => $totalSelesai,
            'totalDiproses' => $totalDiproses,
            'totalMenunggu' => $totalMenunggu,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'perangkatId' => $perangkatId,
            'tanggal_cetak' => now()->format('d-m-Y H:i:s'),
            'dicetak_oleh' => Auth::user()->name,
            'periode' => $this->getPeriodeText($startDate, $endDate),
        ];

        $pdf = Pdf::loadView('pdf.rekap-laporan', $data);
        $pdf->setPaper('A4', 'portrait'); // Sudah portrait

        return $pdf->stream('Rekap-Laporan-Kerusakan-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Format teks periode
     */
    private function getPeriodeText($startDate, $endDate)
    {
        if ($startDate && $endDate) {
            return date('d-m-Y', strtotime($startDate)) . ' s/d ' . date('d-m-Y', strtotime($endDate));
        }
        return 'Semua Periode';
    }
}