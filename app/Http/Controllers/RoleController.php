<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Tampil Data
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('role.index', compact('roles'));
    }

    // Form Tambah
    public function create()
    {
        return view('role.create');
    }

    // Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50|unique:roles,nama',
        ]);

        Role::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('role.index')->with('success', 'Data Role berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('role.edit', compact('role'));
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:50|unique:roles,nama,' . $id,
        ]);

        $role->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('role.index')->with('success', 'Data Role berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Data Role berhasil dihapus!');
    }
}