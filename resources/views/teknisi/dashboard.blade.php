<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Teknisi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. KARTU STATISTIK RINGKAS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Box Tugas Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500">Tugas Hari Ini</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800">{{ $tugasHariIniCount }}</div>
                    <div class="text-xs text-gray-400 mt-1">Ditugaskan tanggal {{ date('d M Y') }}</div>
                </div>

                <!-- Box Tugas Belum Selesai -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 border-l-4 border-yellow-500">
                    <div class="text-sm font-medium text-gray-500">Tugas Belum Selesai</div>
                    <div class="mt-2 text-3xl font-bold text-yellow-600">{{ $tugasBelumSelesaiCount }}</div>
                    <div class="text-xs text-gray-400 mt-1">Membutuhkan perbaikan / penanganan</div>
                </div>

                <!-- Box Riwayat Servis -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500">Riwayat Servis</div>
                    <div class="mt-2 text-3xl font-bold text-green-600">{{ $riwayatServisCount }}</div>
                    <div class="text-xs text-gray-400 mt-1">Total perbaikan yang berhasil diselesaikan</div>
                </div>
            </div>

            <!-- 2. TABEL TUGAS BELUM SELESAI -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4 border-b pb-3">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <span>🛠️</span> Daftar Tugas Perbaikan (Belum Selesai)
                    </h3>
                    <span class="text-xs bg-yellow-100 text-yellow-800 font-semibold px-2.5 py-1 rounded-full">
                        {{ $tugasAktifs->count() }} Tugas Aktif
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-xs text-gray-700 uppercase">
                                <th class="border border-gray-300 px-3 py-2 text-center">No</th>
                                <th class="border border-gray-300 px-3 py-2 text-left">Perangkat & Lokasi</th>
                                <th class="border border-gray-300 px-3 py-2 text-left">Kendala / Deskripsi</th>
                                <th class="border border-gray-300 px-3 py-2 text-center">Urgensi</th>
                                <th class="border border-gray-300 px-3 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-200">
                            @forelse($tugasAktifs as $index => $tugas)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-3 py-2 text-center text-gray-600">{{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <div class="font-bold text-gray-800">{{ $tugas->laporan->perangkat->nama_perangkat ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">📍 {{ $tugas->laporan->ruangan->nama_ruangan ?? '-' }}</div>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-gray-600 text-xs">
                                        {{ Str::limit($tugas->laporan->deskripsi_kerusakan ?? '-', 60) }}
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-center">
                                        <span class="px-2 py-0.5 text-xs font-bold rounded {{ ($tugas->laporan->tingkat_urgensi ?? '') == 'tinggi' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($tugas->laporan->tingkat_urgensi ?? 'Sedang') }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-center">
                                        <a href="{{ route('tindakan-perbaikan.create', ['penugasan_id' => $tugas->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-1.5 px-3 rounded shadow">
                                            + Input Perbaikan
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                        🎉 Tidak ada tugas perbaikan yang tertunda!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

                        <!-- 3. TABEL RIWAYAT SERVIS (PERSIS GAYA ADMIN) -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Tabel Tindakan Perbaikan / Riwayat Servis</h3>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3 border-r">No</th>
                                    <th scope="col" class="px-6 py-3 border-r">ID Penugasan</th>
                                    <th scope="col" class="px-6 py-3 border-r">Deskripsi Tindakan</th>
                                    <th scope="col" class="px-6 py-3 border-r">Tanggal Selesai</th>
                                    <th scope="col" class="px-6 py-3 border-r">Biaya (Rp)</th>
                                    <th scope="col" class="px-6 py-3 text-center">Catatan Teknisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatServises as $index => $riwayat)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 border-r font-medium text-gray-900 whitespace-nowrap">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 border-r">
                                            PEN-{{ $riwayat->penugasan_id }}
                                        </td>
                                        <td class="px-6 py-4 border-r">
                                            {{ $riwayat->deskripsi_tindakan }}
                                        </td>
                                        <td class="px-6 py-4 border-r">
                                            {{ \Carbon\Carbon::parse($riwayat->tanggal_selesai)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 border-r">
                                            {{ number_format($riwayat->biaya, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $riwayat->catatan_teknisi ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            Tidak ada data riwayat servis.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>