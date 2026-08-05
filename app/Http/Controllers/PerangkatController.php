<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class PerangkatController extends Controller
{
    // Tampil Data
    public function index()
    {
        // 'with('ruangan')' digunakan agar query relasi lebih cepat dan efisien
        $perangkats = Perangkat::with('ruangan')->latest()->paginate(10);
        return view('perangkat.index', compact('perangkats'));
    }

    // Form Tambah
    public function create()
    {
        $ruangans = Ruangan::all();
        return view('perangkat.create', compact('ruangans'));
    }

    // Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'kode_perangkat' => 'required|string|max:30|unique:perangkats,kode_perangkat',
            'nama_perangkat' => 'required|string|max:255',
            'jenis_perangkat' => 'required|string|max:100',
            'merk' => 'required|string|max:100',
            'ruangan_id' => 'required|exists:ruangans,id',
            'tahun_pembelian' => 'required|date',
            'status' => 'required|in:Aktif,rusak,servis',
        ]);

        Perangkat::create([
            'kode_perangkat' => $request->kode_perangkat,
            'nama_perangkat' => $request->nama_perangkat,
            'jenis_perangkat' => $request->jenis_perangkat,
            'merk' => $request->merk,
            'ruangan_id' => $request->ruangan_id,
            'tahun_pembelian' => $request->tahun_pembelian,
            'status' => $request->status,
        ]);

        return redirect()->route('perangkat.index')->with('success', 'Data Perangkat berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        $perangkat = Perangkat::findOrFail($id);
        $ruangans = Ruangan::all();
        return view('perangkat.edit', compact('perangkat', 'ruangans'));
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $perangkat = Perangkat::findOrFail($id);

        $request->validate([
            'kode_perangkat' => 'required|string|max:30|unique:perangkats,kode_perangkat,' . $id,
            'nama_perangkat' => 'required|string|max:255',
            'jenis_perangkat' => 'required|string|max:100',
            'merk' => 'required|string|max:100',
            'ruangan_id' => 'required|exists:ruangans,id',
            'tahun_pembelian' => 'required|date',
            'status' => 'required|in:Aktif,rusak,servis',
        ]);

        $perangkat->update([
            'kode_perangkat' => $request->kode_perangkat,
            'nama_perangkat' => $request->nama_perangkat,
            'jenis_perangkat' => $request->jenis_perangkat,
            'merk' => $request->merk,
            'ruangan_id' => $request->ruangan_id,
            'tahun_pembelian' => $request->tahun_pembelian,
            'status' => $request->status,
        ]);

        return redirect()->route('perangkat.index')->with('success', 'Data Perangkat berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $perangkat = Perangkat::findOrFail($id);
        $perangkat->delete();

        return redirect()->route('perangkat.index')->with('success', 'Data Perangkat berhasil dihapus!');
    }
}