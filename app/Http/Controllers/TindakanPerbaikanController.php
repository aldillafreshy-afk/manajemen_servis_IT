<?php

namespace App\Http\Controllers;

use App\Models\TindakanPerbaikan;
use App\Models\PenugasanTeknisi;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TindakanPerbaikanController extends Controller
{
    public function index()
    {
        $tindakans = TindakanPerbaikan::with(['penugasan.laporan.perangkat', 'penugasan.teknisi'])
            ->latest()
            ->paginate(10);

        return view('tindakan_perbaikan.index', compact('tindakans'));
    }

    public function create()
    {
        $penugasans = PenugasanTeknisi::with(['laporan.perangkat', 'teknisi'])
            ->where('status_penugasan', '!=', 'dibatalkan')
            ->get();

        return view('tindakan_perbaikan.create', compact('penugasans'));
    }

    public function store(Request $request)
    {
        // Bersihkan titik ribuan dari input biaya (misal: 950.000 menjadi 950000)
        if ($request->has('biaya')) {
            $biayaCleaned = str_replace('.', '', $request->biaya);
            $biayaCleaned = str_replace(',', '.', $biayaCleaned);
            $request->merge(['biaya' => $biayaCleaned]);
        }

        $request->validate([
            'penugasan_id' => 'required|exists:penugasan_teknisis,id',
            'deskripsi_tindakan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_hasil' => 'required|string',
            'biaya' => 'nullable|numeric|min:0',
            'catatan_teknisi' => 'nullable|string',
        ]);

        TindakanPerbaikan::create([
            'penugasan_id' => $request->penugasan_id,
            'deskripsi_tindakan' => $request->deskripsi_tindakan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_hasil' => $request->status_hasil,
            'biaya' => $request->biaya ?? 0,
            'catatan_teknisi' => $request->catatan_teknisi,
        ]);

        // Jika status hasil 'berhasil', otomatis selesaikan penugasan & laporan
        if ($request->status_hasil === 'berhasil') {
            $penugasan = PenugasanTeknisi::findOrFail($request->penugasan_id);
            $penugasan->update(['status_penugasan' => 'selesai']);

            if ($penugasan->laporan) {
                $statusLama = $penugasan->laporan->status;
                $penugasan->laporan->update(['status' => 'selesai']);

                // Catat riwayat status selesai
                RiwayatStatus::create([
                    'laporan_id' => $penugasan->laporan_id,
                    'user_id' => Auth::id(),
                    'status_lama' => $statusLama,
                    'status_baru' => 'selesai',
                    'keterangan' => 'Tindakan perbaikan berhasil diselesaikan oleh teknisi.',
                ]);
            }
        }

        return redirect()->route('tindakan-perbaikan.index')->with('success', 'Tindakan perbaikan berhasil dicatat!');
    }

    public function edit($id)
    {
        $tindakan = TindakanPerbaikan::findOrFail($id);
        $penugasans = PenugasanTeknisi::with(['laporan.perangkat', 'teknisi'])->get();

        return view('tindakan_perbaikan.edit', compact('tindakan', 'penugasans'));
    }

    public function update(Request $request, $id)
    {
        $tindakan = TindakanPerbaikan::findOrFail($id);

        // Bersihkan titik ribuan dari input biaya
        if ($request->has('biaya')) {
            $biayaCleaned = str_replace('.', '', $request->biaya);
            $biayaCleaned = str_replace(',', '.', $biayaCleaned);
            $request->merge(['biaya' => $biayaCleaned]);
        }

        $request->validate([
            'deskripsi_tindakan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_hasil' => 'required|string',
            'biaya' => 'nullable|numeric|min:0',
            'catatan_teknisi' => 'nullable|string',
        ]);

        $tindakan->update([
            'deskripsi_tindakan' => $request->deskripsi_tindakan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_hasil' => $request->status_hasil,
            'biaya' => $request->biaya ?? 0,
            'catatan_teknisi' => $request->catatan_teknisi,
        ]);

        // Jika diubah menjadi 'berhasil'
        if ($request->status_hasil === 'berhasil') {
            $penugasan = PenugasanTeknisi::find($tindakan->penugasan_id);
            if ($penugasan) {
                $penugasan->update(['status_penugasan' => 'selesai']);

                if ($penugasan->laporan && $penugasan->laporan->status !== 'selesai') {
                    $statusLama = $penugasan->laporan->status;
                    $penugasan->laporan->update(['status' => 'selesai']);

                    RiwayatStatus::create([
                        'laporan_id' => $penugasan->laporan_id,
                        'user_id' => Auth::id(),
                        'status_lama' => $statusLama,
                        'status_baru' => 'selesai',
                        'keterangan' => 'Tindakan perbaikan berhasil diperbarui ke status selesai.',
                    ]);
                }
            }
        }

        return redirect()->route('tindakan-perbaikan.index')->with('success', 'Tindakan perbaikan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tindakan = TindakanPerbaikan::findOrFail($id);
        $tindakan->delete();

        return redirect()->route('tindakan-perbaikan.index')->with('success', 'Data tindakan berhasil dihapus!');
    }
}