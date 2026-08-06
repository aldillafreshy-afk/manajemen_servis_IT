<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Perangkat;
use App\Models\LaporanKerusakan;
use App\Models\User;
use App\Models\PenugasanTeknisi;
use App\Models\JenisKerusakan;
use App\Models\TindakanPerbaikan; // ← TAMBAHKAN INI

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil nama role user yang sedang login
        $roleUser = $user->role;
        $roleName = strtolower(is_object($roleUser) ? ($roleUser->nama ?? '') : ($roleUser ?? ''));

        // =====================================================================
        // 1. DATA DASHBOARD ADMIN
        // =====================================================================
        if ($roleName === 'admin') {
            $totalPerangkat = class_exists(Perangkat::class) ? Perangkat::count() : 0;
            $totalLaporan   = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::count() : 0;
            
            $servisSelesai  = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('status', 'Selesai')->count() : 0;
            $servisDiproses = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::whereIn('status', ['Diproses', 'Menunggu'])->count() : 0;
            
            $teknisiAktif   = class_exists(User::class) ? User::whereHas('role', function($q) {
                $q->where('nama', 'LIKE', '%teknisi%');
            })->count() : 0;

            $laporanTerbaru = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::with(['user', 'perangkat'])->latest()->take(5)->get() : [];

            // Data untuk grafik admin
            $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $dataPerBulan = [];
            $tahunSekarang = date('Y');
            
            if (class_exists(LaporanKerusakan::class)) {
                for ($i = 1; $i <= 12; $i++) {
                    $dataPerBulan[] = LaporanKerusakan::whereYear('created_at', $tahunSekarang)
                        ->whereMonth('created_at', $i)
                        ->count();
                }
            } else {
                $dataPerBulan = array_fill(0, 12, 0);
            }

            $labelsKerusakan = [];
            $dataKerusakan = [];
            $warnaKerusakan = ['#3b82f6', '#10b981', '#f97316', '#8b5cf6', '#ef4444', '#06b6d4'];

            if (class_exists(LaporanKerusakan::class)) {
                $jenisKerusakan = LaporanKerusakan::select('jenis_kerusakan_id', DB::raw('count(*) as total'))
                    ->whereNotNull('jenis_kerusakan_id')
                    ->groupBy('jenis_kerusakan_id')
                    ->orderBy('total', 'desc')
                    ->limit(5)
                    ->get();
                
                foreach ($jenisKerusakan as $item) {
                    $jenis = JenisKerusakan::find($item->jenis_kerusakan_id);
                    if ($jenis) {
                        $labelsKerusakan[] = $jenis->nama;
                        $dataKerusakan[] = $item->total;
                    }
                }
            }

            if (empty($labelsKerusakan) || array_sum($dataKerusakan) == 0) {
                $labelsKerusakan = ['Belum Ada Data'];
                $dataKerusakan = [1];
                $warnaKerusakan = ['#94a3b8'];
            }

            return view('dashboard', compact(
                'totalPerangkat', 
                'totalLaporan', 
                'servisSelesai', 
                'servisDiproses', 
                'teknisiAktif', 
                'laporanTerbaru',
                'bulanLabels',
                'dataPerBulan',
                'labelsKerusakan',
                'dataKerusakan',
                'warnaKerusakan'
            ));
        } 
        
        // =====================================================================
        // 2. DATA DASHBOARD TEKNISI (PERBAIKAN TOTAL)
        // =====================================================================
        elseif ($roleName === 'teknisi') {
            $teknisiId = $user->id;
            $hariIni = date('Y-m-d');

            // --- 1. Data untuk Kartu Statistik ---
            $tugasHariIniCount = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $teknisiId)
                    ->whereDate('tanggal_penugasan', $hariIni)
                    ->whereIn('status_penugasan', ['Menunggu', 'Diproses', 'ditugaskan'])
                    ->count() 
                : 0;

            $tugasBelumSelesaiCount = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $teknisiId)
                    ->whereIn('status_penugasan', ['Menunggu', 'Diproses', 'ditugaskan'])
                    ->count() 
                : 0;

            $riwayatServisCount = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $teknisiId)
                    ->where('status_penugasan', 'Selesai')
                    ->count() 
                : 0;

            // --- 2. Data Tugas Belum Selesai ---
            $tugasAktifs = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::with(['laporan.perangkat', 'laporan.ruangan', 'laporan.jenisKerusakan'])
                    ->where('teknisi_id', $teknisiId)
                    ->whereIn('status_penugasan', ['Menunggu', 'Diproses', 'ditugaskan'])
                    ->latest()
                    ->take(50) // ← TAMBAHKAN LIMIT
                    ->get() 
                : [];

            // --- 3. Data Riwayat Servis ---
            $riwayatServises = class_exists(TindakanPerbaikan::class) 
                ? TindakanPerbaikan::with(['penugasan.laporan.perangkat', 'penugasan.laporan.ruangan'])
                    ->whereHas('penugasan', function($q) use ($teknisiId) {
                        $q->where('teknisi_id', $teknisiId);
                    })
                    ->latest()
                    ->take(10)
                    ->get() 
                : [];

            // --- 4. Data untuk Grafik Teknisi ---
            $totalDiproses = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $teknisiId)
                    ->whereIn('status_penugasan', ['Diproses', 'ditugaskan'])
                    ->count() 
                : 0;

            $totalSelesai = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $teknisiId)
                    ->where('status_penugasan', 'Selesai')
                    ->count() 
                : 0;

            $totalPending = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $teknisiId)
                    ->where('status_penugasan', 'Menunggu')
                    ->count() 
                : 0;

            return view('dashboard', compact(
                'tugasHariIniCount',
                'tugasBelumSelesaiCount',
                'riwayatServisCount',
                'tugasAktifs',
                'riwayatServises',
                'totalDiproses',
                'totalSelesai',
                'totalPending'
            ));
        } 
        
        // =====================================================================
        // 3. DATA DASHBOARD PELAPOR / USER
        // =====================================================================
        else {
            $totalLaporanSaya = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->count() : 0;
            $statusDiproses = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->where('status', 'Diproses')->count() : 0;
            $statusSelesai  = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->where('status', 'Selesai')->count() : 0;
            $statusMenunggu = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->where('status', 'Menunggu')->count() : 0;
            $laporanSaya = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->latest()->take(5)->get() : [];

            return view('dashboard', compact(
                'totalLaporanSaya', 
                'statusDiproses', 
                'statusSelesai', 
                'statusMenunggu', 
                'laporanSaya'
            ));
        }
    }
}