<?php

namespace App\Http\Controllers;

use App\Models\PenugasanTeknisi;
use App\Models\LaporanKerusakan;
use App\Models\TindakanPerbaikan;
use App\Models\User;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenugasanTeknisiController extends Controller
{
    public function dashboardTeknisi()
    {
        $teknisiId = Auth::id();
        $hariIni = date('Y-m-d');

        // 1. Counter/Statistik Ringkas
        $tugasHariIniCount = PenugasanTeknisi::where('teknisi_id', $teknisiId)
            ->whereDate('tanggal_penugasan', $hariIni)
            ->count();

        $tugasBelumSelesaiCount = PenugasanTeknisi::where('teknisi_id', $teknisiId)
            ->where('status_penugasan', '!=', 'selesai')
            ->count();

        $riwayatServisCount = PenugasanTeknisi::where('teknisi_id', $teknisiId)
            ->where('status_penugasan', 'selesai')
            ->count();

        // 2. Data Tugas Belum Selesai (Aktif)
        $tugasAktifs = PenugasanTeknisi::with(['laporan.perangkat', 'laporan.ruangan', 'laporan.jenisKerusakan'])
            ->where('teknisi_id', $teknisiId)
            ->where('status_penugasan', '!=', 'selesai')
            ->latest()
            ->get();

        // 3. Data Riwayat Servis (Selesai)
        $riwayatServises = TindakanPerbaikan::with(['penugasan.laporan.perangkat', 'penugasan.laporan.ruangan'])
            ->whereHas('penugasan', function($q) use ($teknisiId) {
                $q->where('teknisi_id', $teknisiId);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('teknisi.dashboard', compact(
            'tugasHariIniCount',
            'tugasBelumSelesaiCount',
            'riwayatServisCount',
            'tugasAktifs',
            'riwayatServises'
        ));
    }

    public function tugasSaya()
    {
        // Ambil penugasan khusus untuk teknisi yang sedang login
        $penugasans = PenugasanTeknisi::with(['laporan.perangkat', 'laporan.ruangan', 'laporan.jenisKerusakan'])
            ->where('teknisi_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('teknisi.tugas', compact('penugasans'));
    }

    public function index()
    {
        $penugasans = PenugasanTeknisi::with(['laporan.perangkat', 'teknisi'])
            ->latest()
            ->paginate(10);

        return view('penugasan.index', compact('penugasans'));
    }

    public function create()
    {
        // Ambil laporan yang belum selesai
        $laporans = LaporanKerusakan::with(['perangkat', 'ruangan'])
            ->whereNotIn('status', ['selesai', 'Selesai', 'SELESAI'])
            ->get();

        // Ambil user teknisi
        $teknisis = User::whereHas('role', function ($query) {
            $query->where('name', 'teknisi')
                ->orWhere('name', 'Teknisi');
        })->get();

        return view('penugasan.create', compact('laporans', 'teknisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'laporan_id' => 'required|exists:laporan_kerusakans,id',
            'teknisi_id' => 'required|exists:users,id',
            'tanggal_penugasan' => 'required|date',
            'catatan_admin' => 'nullable|string',
        ]);

        PenugasanTeknisi::create([
            'laporan_id' => $request->laporan_id,
            'teknisi_id' => $request->teknisi_id,
            'tanggal_penugasan' => $request->tanggal_penugasan,
            'status_penugasan' => 'ditugaskan',
            'catatan_admin' => $request->catatan_admin,
        ]);

        // Otomatis ubah status di Laporan Kerusakan menjadi 'diproses'
        $laporan = LaporanKerusakan::findOrFail($request->laporan_id);
        $statusLama = $laporan->status;
        $laporan->update(['status' => 'diproses']);

        // Catat riwayat status
        RiwayatStatus::create([
            'laporan_id' => $laporan->id,
            'user_id' => Auth::id(),
            'status_lama' => $statusLama,
            'status_baru' => 'diproses',
            'keterangan' => 'Admin menugaskan teknisi untuk melakukan perbaikan.',
        ]);

        return redirect()->route('penugasan.index')->with('success', 'Teknisi berhasil ditugaskan!');
    }

    public function edit($id)
    {
        $penugasan = PenugasanTeknisi::findOrFail($id);
        $laporans = LaporanKerusakan::all();
        $teknisis = User::whereHas('role', function ($query) {
            $query->where('name', 'teknisi');
        })->get();

        return view('penugasan.edit', compact('penugasan', 'laporans', 'teknisis'));
    }

    public function update(Request $request, $id)
    {
        $penugasan = PenugasanTeknisi::findOrFail($id);

        $request->validate([
            'teknisi_id' => 'required|exists:users,id',
            'tanggal_penugasan' => 'required|date',
            'status_penugasan' => 'required|string',
            'catatan_admin' => 'nullable|string',
        ]);

        $penugasan->update([
            'teknisi_id' => $request->teknisi_id,
            'tanggal_penugasan' => $request->tanggal_penugasan,
            'status_penugasan' => $request->status_penugasan,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('penugasan.index')->with('success', 'Data penugasan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penugasan = PenugasanTeknisi::findOrFail($id);
        $penugasan->delete();

        return redirect()->route('penugasan.index')->with('success', 'Penugasan berhasil dihapus!');
    }
}