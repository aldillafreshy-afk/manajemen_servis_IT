<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStatus;
use Illuminate\Http\Request;

class RiwayatStatusController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatStatus::with(['laporan.perangkat', 'laporan.ruangan', 'user'])
            ->latest();

        // Fitur Filter Berdasarkan ID Laporan (jika dicari dari detail laporan)
        if ($request->has('laporan_id') && $request->laporan_id != '') {
            $query->where('laporan_id', $request->laporan_id);
        }

        $riwayats = $query->paginate(15);

        return view('riwayat_status.index', compact('riwayats'));
    }
}