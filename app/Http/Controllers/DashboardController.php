<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perangkat;       // Sesuaikan nama model perangkat kamu
use App\Models\LaporanKerusakan; // Sesuaikan nama model laporan kamu (misal: Laporan)
use App\Models\User;

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
            // Tugas hari ini / yang sedang ditangani oleh teknisi yang login
            $tugasHariIni = class_exists(LaporanKerusakan::class) 
                ? LaporanKerusakan::where('teknisi_id', $user->id)
                    ->whereIn('status', ['Diproses', 'Menunggu'])
                    ->latest()->take(5)->get() 
                : [];

            // Riwayat servis yang telah diselesaikan oleh teknisi ini
            $riwayatServis = class_exists(LaporanKerusakan::class) 
                ? LaporanKerusakan::where('teknisi_id', $user->id)
                    ->where('status', 'Selesai')
                    ->latest()->take(5)->get() 
                : [];

            // Angka hitungan ringkasan tugas
            $totalDiproses = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('teknisi_id', $user->id)->where('status', 'Diproses')->count() : 0;
            $totalSelesai  = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('teknisi_id', $user->id)->where('status', 'Selesai')->count() : 0;
            $totalPending  = class_exists(LaporanKerusakan::class) ? LaporanKerusakan::where('teknisi_id', $user->id)->where('status', 'Menunggu')->count() : 0;

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