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

        $tindakan = TindakanPerbaikan::create([
            'penugasan_id' => $request->penugasan_id,
            'deskripsi_tindakan' => $request->deskripsi_tindakan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_hasil' => $request->status_hasil,
            'biaya' => $request->biaya ?? 0,
            'catatan_teknisi' => $request->catatan_teknisi,
        ]);

        $penugasan = PenugasanTeknisi::findOrFail($request->penugasan_id);
        $laporan = $penugasan->laporan;
        $catatanTeknisi = trim($request->catatan_teknisi ?? '');

        // Jika status hasil 'berhasil', otomatis selesaikan penugasan & laporan
        if ($request->status_hasil === 'berhasil') {
            $penugasan->update(['status_penugasan' => 'selesai']);

            if ($laporan) {
                $statusLama = $laporan->status;
                $laporan->update(['status' => 'selesai']);

                $keterangan = 'Tindakan perbaikan berhasil diselesaikan oleh teknisi.';
                if ($catatanTeknisi !== '') {
                    $keterangan .= ' Catatan teknisi: ' . $catatanTeknisi;
                }

                RiwayatStatus::create([
                    'laporan_id' => $laporan->id,
                    'user_id' => Auth::id(),
                    'status_lama' => $statusLama,
                    'status_baru' => 'selesai',
                    'keterangan' => $keterangan,
                ]);
            }
        } elseif ($laporan && $catatanTeknisi !== '') {
            RiwayatStatus::create([
                'laporan_id' => $laporan->id,
                'user_id' => Auth::id(),
                'status_lama' => $laporan->status,
                'status_baru' => $laporan->status,
                'keterangan' => 'Catatan teknisi: ' . $catatanTeknisi,
            ]);
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

        $catatanTeknisi = trim($request->catatan_teknisi ?? '');
        $penugasan = PenugasanTeknisi::find($tindakan->penugasan_id);
        $laporan = $penugasan?->laporan;

        // Jika diubah menjadi 'berhasil'
        if ($request->status_hasil === 'berhasil') {
            if ($penugasan) {
                $penugasan->update(['status_penugasan' => 'selesai']);

                if ($laporan) {
                    if ($laporan->status !== 'selesai') {
                        $statusLama = $laporan->status;
                        $laporan->update(['status' => 'selesai']);

                        $keterangan = 'Tindakan perbaikan berhasil diperbarui ke status selesai.';
                        if ($catatanTeknisi !== '') {
                            $keterangan .= ' Catatan teknisi: ' . $catatanTeknisi;
                        }

                        RiwayatStatus::create([
                            'laporan_id' => $laporan->id,
                            'user_id' => Auth::id(),
                            'status_lama' => $statusLama,
                            'status_baru' => 'selesai',
                            'keterangan' => $keterangan,
                        ]);
                    } elseif ($catatanTeknisi !== '') {
                        RiwayatStatus::create([
                            'laporan_id' => $laporan->id,
                            'user_id' => Auth::id(),
                            'status_lama' => $laporan->status,
                            'status_baru' => $laporan->status,
                            'keterangan' => 'Catatan teknisi: ' . $catatanTeknisi,
                        ]);
                    }
                }
            }
        } elseif ($laporan && $catatanTeknisi !== '') {
            RiwayatStatus::create([
                'laporan_id' => $laporan->id,
                'user_id' => Auth::id(),
                'status_lama' => $laporan->status,
                'status_baru' => $laporan->status,
                'keterangan' => 'Catatan teknisi: ' . $catatanTeknisi,
            ]);
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