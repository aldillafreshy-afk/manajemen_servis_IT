<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    // Tampil Data
    public function index()
    {
        $ruangans = Ruangan::latest()->paginate(10);
        return view('ruangan.index', compact('ruangans'));
    }

    // Form Tambah
    public function create()
    {
        return view('ruangan.create');
    }

    // Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'kode_ruangan' => 'required|string|max:30|unique:ruangans,kode_ruangan',
            'nama_ruangan' => 'required|string|max:255',
        ]);

        Ruangan::create([
            'kode_ruangan' => $request->kode_ruangan,
            'nama_ruangan' => $request->nama_ruangan,
        ]);

        return redirect()->route('ruangan.index')->with('success', 'Data Ruangan berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruangan'));
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $request->validate([
            'kode_ruangan' => 'required|string|max:30|unique:ruangans,kode_ruangan,' . $id,
            'nama_ruangan' => 'required|string|max:255',
        ]);

        $ruangan->update([
            'kode_ruangan' => $request->kode_ruangan,
            'nama_ruangan' => $request->nama_ruangan,
        ]);

        return redirect()->route('ruangan.index')->with('success', 'Data Ruangan berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('ruangan.index')->with('success', 'Data Ruangan berhasil dihapus!');
    }
}