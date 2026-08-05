<?php

namespace App\Http\Controllers;

use App\Models\JenisKerusakan;
use Illuminate\Http\Request;

class JenisKerusakanController extends Controller
{
    // Tampil Data
    public function index()
    {
        $jenisKerusakans = JenisKerusakan::latest()->paginate(10);
        return view('jenis_kerusakan.index', compact('jenisKerusakans'));
    }

    // Form Tambah
    public function create()
    {
        return view('jenis_kerusakan.create');
    }

    // Simpan Data
    public function store(Request $request)
    {
        // Perbaikan: Ganti nama_jenis menjadi nama_kerusakan
        $request->validate([
            'nama_kerusakan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        JenisKerusakan::create([
            'nama_kerusakan' => $request->nama_kerusakan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jenis-kerusakan.index')->with('success', 'Jenis kerusakan berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        $jenisKerusakan = JenisKerusakan::findOrFail($id);
        return view('jenis_kerusakan.edit', compact('jenisKerusakan'));
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $jenisKerusakan = JenisKerusakan::findOrFail($id);

        // Perbaikan: Ganti nama_jenis menjadi nama_kerusakan
        $request->validate([
            'nama_kerusakan' => 'required|string|max:255|unique:jenis_kerusakans,nama_kerusakan,' . $id,
            'deskripsi' => 'nullable|string',
        ]);

        $jenisKerusakan->update([
            'nama_kerusakan' => $request->nama_kerusakan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jenis-kerusakan.index')->with('success', 'Jenis kerusakan berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $jenisKerusakan = JenisKerusakan::findOrFail($id);
        $jenisKerusakan->delete();

        return redirect()->route('jenis-kerusakan.index')->with('success', 'Jenis kerusakan berhasil dihapus!');
    }
}