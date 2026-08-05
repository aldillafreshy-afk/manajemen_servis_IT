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
    public function index()
    {
        $laporans = LaporanKerusakan::with(['user', 'perangkat', 'ruangan', 'jenisKerusakan'])
            ->latest()
            ->paginate(10);

        return view('laporan.index', compact('laporans'));
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
        ]);

        LaporanKerusakan::create([
            'user_id' => Auth::id(), // Otomatis menyimpan ID Pelapor yang login
            'ruangan_id' => $request->ruangan_id,
            'perangkat_id' => $request->perangkat_id,
            'jenis_kerusakan_id' => $request->jenis_kerusakan_id,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'tingkat_urgensi' => $request->tingkat_urgensi ?? 'sedang',
            'status_laporan' => 'pending', // Status awal laporan
            'tanggal_laporan' => now(),
        ]);

        // UBAH BARIS INI: Dari 'laporan_kerusakan.index' menjadi 'laporan.index'
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
}