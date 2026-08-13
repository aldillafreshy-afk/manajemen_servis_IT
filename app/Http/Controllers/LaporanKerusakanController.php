<?php

namespace App\Http\Controllers;

use App\Models\LaporanKerusakan;
use App\Models\Perangkat;
use App\Models\Ruangan;
use App\Models\JenisKerusakan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKerusakanController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        $roleName = strtolower(optional($role)->nama ?? optional($role)->name ?? '');

        $query = LaporanKerusakan::with(['user', 'perangkat', 'ruangan', 'jenisKerusakan']);

        if ($roleName === 'teknisi') {
            $query->whereHas('penugasanTeknisi', function ($q) {
                $q->where('teknisi_id', Auth::id());
            });
        } elseif ($roleName !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($q2) use ($q) {
                $q2->where('deskripsi_kerusakan', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%")
                    ->orWhere('tingkat_urgensi', 'like', "%{$q}%")
                    ->orWhereHas('user', fn($q3) => $q3->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('perangkat', fn($q3) => $q3->where('nama_perangkat', 'like', "%{$q}%"))
                    ->orWhereHas('ruangan', fn($q3) => $q3->where('nama_ruangan', 'like', "%{$q}%"))
                    ->orWhereHas('jenisKerusakan', fn($q3) => $q3->where('nama_kerusakan', 'like', "%{$q}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tingkat_urgensi')) {
            $query->where('tingkat_urgensi', $request->tingkat_urgensi);
        }

        if ($request->filled('perangkat_id')) {
            $query->where('perangkat_id', $request->perangkat_id);
        }

        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }

        if ($request->filled('jenis_kerusakan_id')) {
            $query->where('jenis_kerusakan_id', $request->jenis_kerusakan_id);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_lapor', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_lapor', '<=', $request->tanggal_akhir);
        }

        $laporans = $query->latest()->paginate(10)->withQueryString();
        $ruangans = Ruangan::all();
        $jenisKerusakans = JenisKerusakan::all();
        $perangkats = Perangkat::all();

        return view('laporan.index', compact('laporans', 'ruangans', 'jenisKerusakans', 'perangkats'));
    }

    public function show($id)
    {
        // Ambil data laporan beserta relasi yang dibutuhkan
        $laporan = LaporanKerusakan::with(['user', 'perangkat', 'ruangan', 'jenisKerusakan'])
            ->findOrFail($id);
        
        // Ambil riwayat status jika ada
        $riwayatStatus = RiwayatStatus::where('laporan_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('laporan.show', compact('laporan', 'riwayatStatus'));
    }
    
    public function create()
    {
        $ruangans = Ruangan::all();
        $jenisKerusakans = JenisKerusakan::all();
        $perangkats = Perangkat::all();

        return view('laporan.create', compact('ruangans', 'jenisKerusakans', 'perangkats'));
    }

    // Proses Simpan Laporan dari Pelapor
    public function store(Request $request)
{
    $request->validate([
        'ruangan_id' => 'required|exists:ruangans,id',
        'perangkat_id' => 'required|exists:perangkats,id',
        'jenis_kerusakan_id' => 'required|exists:jenis_kerusakans,id',
        'deskripsi_kerusakan' => 'required|string',
        'tingkat_urgensi' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan validasi foto
    ]);

    // Upload foto jika ada
    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
    }

    LaporanKerusakan::create([
        'user_id' => Auth::id(),
        'ruangan_id' => $request->ruangan_id,
        'perangkat_id' => $request->perangkat_id,
        'jenis_kerusakan_id' => $request->jenis_kerusakan_id,
        'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
        'tingkat_urgensi' => $request->tingkat_urgensi ?? 'sedang',
        'status_laporan' => 'menunggu',
        'tanggal_laporan' => now(),
        'foto' => $fotoPath, // Tambahkan field foto
    ]);

    return redirect()->route('laporan.index')->with('success', 'Laporan kerusakan berhasil dikirim!');
}

    public function edit($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        $perangkats = Perangkat::all();
        $ruangans = Ruangan::all();
        $jenisKerusakans = JenisKerusakan::all();

        return view('laporan.edit', compact('laporan', 'perangkats', 'ruangans', 'jenisKerusakans'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        $statusLama = $laporan->status;

        $request->validate([
            'perangkat_id'        => 'required|exists:perangkats,id',
            'ruangan_id'          => 'required|exists:ruangans,id',
            'jenis_kerusakan_id'  => 'required|exists:jenis_kerusakans,id',
            'tingkat_urgensi'     => 'required|in:rendah,sedang,tinggi',
            'deskripsi_kerusakan' => 'required|string',
            'status'              => 'required|string',
            'foto'                => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $laporan->foto;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
        }

        $laporan->update([
            'perangkat_id'        => $request->perangkat_id,
            'ruangan_id'          => $request->ruangan_id,
            'jenis_kerusakan_id'  => $request->jenis_kerusakan_id,
            'tingkat_urgensi'     => $request->tingkat_urgensi,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'foto'                => $fotoPath,
            'status'              => $request->status,
        ]);

        if ($statusLama !== $request->status) {
            RiwayatStatus::create([
                'laporan_id'  => $laporan->id,
                'user_id'     => Auth::id(),
                'status_lama' => $statusLama,
                'status_baru' => $request->status,
                'keterangan'  => 'Status laporan diperbarui secara manual.',
            ]);
        }

        return redirect()->route('laporan.index')->with('success', 'Laporan kerusakan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan kerusakan berhasil dihapus!');
    }

    // API: Ambil perangkat berdasarkan ruangan
    public function getPerangkatByRuangan($ruangan_id)
    {
        $perangkats = Perangkat::where('ruangan_id', $ruangan_id)
            ->orderBy('nama_perangkat')
            ->get(['id', 'kode_perangkat', 'nama_perangkat']);

        return response()->json($perangkats);
    }
}