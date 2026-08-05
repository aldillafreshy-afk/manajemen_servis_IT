<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Perangkat;       // Sesuaikan nama model perangkat kamu
use App\Models\LaporanKerusakan; // Sesuaikan nama model laporan kamu (misal: Laporan)
use App\Models\User;
use App\Models\PenugasanTeknisi;
use App\Models\JenisKerusakan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil nama role user yang sedang login
        $roleUser = $user->role;
        $roleName = strtolower(is_object($roleUser) ? ($roleUser->nama ?? '') : ($roleUser ?? ''));

        // =====================================================================
        // 1. DATA DASHBOARD ADMIN (Akurat dari Seluruh Sistem)
        // =====================================================================
        if ($roleName === 'admin') {
            $totalPerangkat = class_exists(Perangkat::class) ? Perangkat::count() : 0;
            $totalLaporan   = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::count() : 0;
            
            // Status perbaikan
            $servisSelesai  = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('status', 'Selesai')->count() : 0;
            $servisDiproses = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::whereIn('status', ['Diproses', 'Menunggu'])->count() : 0;
            
            // Hitung user ber-role teknisi
            $teknisiAktif   = class_exists(User::class) ? User::whereHas('role', function($q) {
                $q->where('nama', 'LIKE', '%teknisi%');
            })->count() : 0;

            // 5 Laporan Terbaru
            $laporanTerbaru = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::with(['user', 'perangkat'])->latest()->take(5)->get() : [];

            // =====================================================================
            // DATA UNTUK GRAFIK - AMBIL DARI DATABASE
            // =====================================================================
            
            // 1. Data Line Chart - Jumlah Laporan per Bulan (Tahun Berjalan)
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

            // 2. Data Doughnut Chart - Jenis Kerusakan Terbanyak
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
                
                // Ambil nama jenis kerusakan dari relasi
                $labelsKerusakan = [];
                $dataKerusakan = [];
                foreach ($jenisKerusakan as $item) {
                    $jenis = JenisKerusakan::find($item->jenis_kerusakan_id);
                    if ($jenis) {
                        $labelsKerusakan[] = $jenis->nama; // atau $jenis->jenis_kerusakan
                        $dataKerusakan[] = $item->total;
                    }
                }
            }

            // Jika tidak ada data, berikan data default
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
                'laporanTerbaru'
            ));
        } 
        
        // =====================================================================
        // 2. DATA DASHBOARD TEKNISI (Akurat Khusus Tugas Teknisi Ini)
        // =====================================================================
        elseif ($roleName === 'teknisi') {
            // Tugas hari ini - dari tabel penugasan_teknisis
            $tugasHariIni = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::with(['laporan', 'teknisi'])
                    ->where('teknisi_id', $user->id)
                    ->whereIn('status_penugasan', ['Diproses', 'Menunggu'])
                    ->latest()->take(5)->get() 
                : [];

            // Riwayat servis yang telah selesai
            $riwayatServis = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::with(['laporan', 'teknisi'])
                    ->where('teknisi_id', $user->id)
                    ->where('status_penugasan', 'Selesai')
                    ->latest()->take(5)->get() 
                : [];

            // Angka hitungan ringkasan tugas
            $totalDiproses = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $user->id)
                    ->where('status_penugasan', 'Diproses')
                    ->count() 
                : 0;
                
            $totalSelesai = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $user->id)
                    ->where('status_penugasan', 'Selesai')
                    ->count() 
                : 0;
                
            $totalPending = class_exists(PenugasanTeknisi::class) 
                ? PenugasanTeknisi::where('teknisi_id', $user->id)
                    ->where('status_penugasan', 'Menunggu')
                    ->count() 
                : 0;

            return view('dashboard', compact(
                'tugasHariIni', 
                'riwayatServis', 
                'totalDiproses', 
                'totalSelesai', 
                'totalPending'
            ));
        } 
        
        // =====================================================================
        // 3. DATA DASHBOARD PELAPOR / USER (Akurat Khusus Laporan Milik Pelapor Ini)
        // =====================================================================
        else {
            // Total laporan yang pernah dibuat oleh user yang login
            $totalLaporanSaya = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->count() : 0;
            
            // Status-status laporan milik user yang login
            $statusDiproses = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->where('status', 'Diproses')->count() : 0;
            $statusSelesai  = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->where('status', 'Selesai')->count() : 0;
            $statusMenunggu = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('user_id', $user->id)->where('status', 'Menunggu')->count() : 0;

            // 5 Laporan Terbaru milik user ini
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