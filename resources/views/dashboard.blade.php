<x-app-layout>
    @php
        // Ambil role langsung dari Auth User secara aman
        $userRole = Auth::user()->role ?? null;
        if (is_object($userRole) || is_array($userRole)) {
            $currentRole = strtolower($userRole['nama'] ?? $userRole->nama ?? '');
        } else {
            $currentRole = strtolower($userRole ?? '');
        }
    @endphp

    <!-- =========================================================================================
         1. DASHBOARD ADMIN
    ========================================================================================== -->
    @if($currentRole === 'admin')
        <div class="space-y-6">
            <!-- Grid 5 Card Ringkasan Utama (Angka Akurat dari Controller) -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalPerangkat ?? 0 }}</div>
                        <div class="text-xs text-gray-500 font-medium">Jumlah Perangkat</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalLaporan ?? 0 }}</div>
                        <div class="text-xs text-gray-500 font-medium">Jumlah Laporan</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $servisSelesai ?? 0 }}</div>
                        <div class="text-xs text-gray-500 font-medium">Servis Selesai</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $servisDiproses ?? 0 }}</div>
                        <div class="text-xs text-gray-500 font-medium">Servis Diproses</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $teknisiAktif ?? 0 }}</div>
                        <div class="text-xs text-gray-500 font-medium">Teknisi Aktif</div>
                    </div>
                </div>
            </div>

            <!-- Grid 2 Grafik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Line Chart: Jumlah Laporan per Bulan -->
                <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800">Grafik Jumlah Laporan per Bulan</h3>
                        <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-lg">Tahun {{ date('Y') }}</span>
                    </div>
                    <div class="h-64">
                        <canvas id="adminLineChart"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart: Jenis Kerusakan Terbanyak -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <h3 class="font-bold text-gray-800 mb-2">Jenis Kerusakan Terbanyak</h3>
                    <div class="h-48 relative flex items-center justify-center">
                        <canvas id="adminDoughnutChart"></canvas>
                    </div>
                    <!-- LEGEND DINAMIS DARI DATABASE -->
                    <div class="mt-4 text-xs space-y-1 text-gray-600 border-t pt-3">
                        @if(!empty($labelsKerusakan) && !empty($dataKerusakan) && $labelsKerusakan[0] !== 'Belum Ada Data')
                            @foreach($labelsKerusakan as $index => $label)
                                <div class="flex justify-between">
                                    <span>
                                        <span class="inline-block w-2.5 h-2.5 rounded-full mr-1" 
                                            style="background-color: {{ $warnaKerusakan[$index % count($warnaKerusakan)] ?? '#3b82f6' }}"></span>
                                        {{ $label }}
                                    </span>
                                    <span>{{ $dataKerusakan[$index] ?? 0 }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-gray-400 py-2">Belum ada data kerusakan</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tabel Laporan Terbaru (Dinamis dari Database) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">Laporan Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="py-3 px-4">No. Laporan</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Perangkat</th>
                                <th class="py-3 px-4">Pelapor</th>
                                <th class="py-3 px-4">Jenis Kerusakan</th>
                                <th class="py-3 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanTerbaru ?? [] as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4 font-semibold text-gray-900">{{ $item->no_laporan ?? 'LP-'.$item->id }}</td>
                                    <td class="py-3 px-4">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</td>
                                    <td class="py-3 px-4">{{ $item->perangkat->nama_perangkat ?? ($item->nama_perangkat ?? '-') }}</td>
                                    <td class="py-3 px-4">{{ $item->user->name ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $item->jenis_kerusakan ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        @if(strtolower($item->status ?? '') === 'selesai')
                                            <span class="bg-green-100 text-green-800 text-xs px-2.5 py-0.5 rounded-full font-medium">Selesai</span>
                                        @elseif(strtolower($item->status ?? '') === 'diproses')
                                            <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-0.5 rounded-full font-medium">Diproses</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full font-medium">{{ $item->status ?? 'Menunggu' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-400">Belum ada data laporan terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <!-- =========================================================================================
         2. DASHBOARD TEKNISI
    ========================================================================================== -->
    @elseif($currentRole === 'teknisi')
        
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


    <!-- =========================================================================================
         3. DASHBOARD PELAPOR / USER
    ========================================================================================== -->
    @else
        <div class="space-y-6">
            <!-- Header Ringkasan Pelapor (Angka Akurat) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-6">
                <div class="p-4 bg-blue-600 text-white rounded-2xl">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <div class="text-sm font-semibold text-gray-500">Jumlah Laporan yang Dibuat</div>
                    <div class="text-3xl font-extrabold text-blue-600 mb-1">{{ $totalLaporanSaya ?? 0 }}</div>
                    <div class="text-xs text-gray-400">Total seluruh laporan kerusakan perangkat yang Anda ajukan</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Donut Chart Status Laporan Saya -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">Status Laporan Saya</h3>
                    <div class="h-48 relative flex items-center justify-center">
                        <canvas id="pelaporDoughnutChart"></canvas>
                    </div>
                </div>

                <!-- Banner Informasi Status Laporan -->
                <div class="md:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                    <svg class="w-20 h-20 text-blue-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <h4 class="font-bold text-gray-900 text-lg mb-1">Tetap pantau status laporan Anda</h4>
                    <p class="text-xs text-gray-500 max-w-sm">Tim teknisi kami akan segera memperbarui setiap tindakan perbaikan perangkat Anda secara berkala.</p>
                </div>
            </div>

            <!-- Tabel Laporan Saya (Dinamis dari Database) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800">Laporan Terbaru</h3>
                    @if(Route::has('laporan.create'))
                        <a href="{{ route('laporan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-md transition">
                            + Buat Laporan Baru
                        </a>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="py-3 px-4">No. Laporan</th>
                                <th class="py-3 px-4">Tanggal Laporan</th>
                                <th class="py-3 px-4">Perangkat</th>
                                <th class="py-3 px-4">Jenis Kerusakan</th>
                                <th class="py-3 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanSaya ?? [] as $lap)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4 font-semibold text-gray-900">{{ $lap->no_laporan ?? 'LP-'.$lap->id }}</td>
                                    <td class="py-3 px-4">{{ $lap->created_at ? $lap->created_at->format('d M Y') : '-' }}</td>
                                    <td class="py-3 px-4">{{ $lap->perangkat->nama_perangkat ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $lap->jenisKerusakan->nama_kerusakan ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        @if(strtolower($lap->status ?? '') === 'selesai')
                                            <span class="bg-green-100 text-green-800 text-xs px-2.5 py-0.5 rounded-full font-medium">Selesai</span>
                                        @elseif(strtolower($lap->status ?? '') === 'diproses')
                                            <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-0.5 rounded-full font-medium">Diproses</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full font-medium">{{ $lap->status ?? 'Menunggu' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-400">Anda belum pernah membuat laporan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- =========================================================================================
         SCRIPT GRAFIK CHART.JS DINAMIS BERDASARKAN VARIABLE DARI CONTROLLER
    ========================================================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if($currentRole === 'admin')
            // 1. Grafik Admin - Line Chart Laporan per Bulan
            const ctxAdminLine = document.getElementById('adminLineChart')?.getContext('2d');
            if (ctxAdminLine) {
                const bulanLabels = {!! json_encode($bulanLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!};
                const dataPerBulan = {!! json_encode($dataPerBulan ?? array_fill(0, 12, 0)) !!};
                
                new Chart(ctxAdminLine, {
                    type: 'line',
                    data: {
                        labels: bulanLabels,
                        datasets: [{
                            label: 'Jumlah Laporan',
                            data: dataPerBulan,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            }
                        }
                    }
                });
            }

            // 2. Grafik Admin - Doughnut Jenis Kerusakan
            const ctxAdminDoughnut = document.getElementById('adminDoughnutChart')?.getContext('2d');
            if (ctxAdminDoughnut) {
                const labelsKerusakan = {!! json_encode($labelsKerusakan ?? ['Hardware', 'Software', 'Jaringan']) !!};
                const dataKerusakan = {!! json_encode($dataKerusakan ?? [0, 0, 0]) !!};
                const warnaKerusakan = {!! json_encode($warnaKerusakan ?? ['#3b82f6', '#10b981', '#f97316']) !!};
                
                new Chart(ctxAdminDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: labelsKerusakan,
                        datasets: [{
                            data: dataKerusakan,
                            backgroundColor: warnaKerusakan
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false, 
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 10,
                                    font: { size: 10 }
                                }
                            }
                        }
                    }
                });
            }
        @endif

            // 3. Grafik Teknisi - Doughnut Status Tugas Akurat dari Data
            const ctxTeknisiDoughnut = document.getElementById('teknisiDoughnutChart')?.getContext('2d');
            if (ctxTeknisiDoughnut) {
                new Chart(ctxTeknisiDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: ['Diproses', 'Selesai', 'Pending'],
                        datasets: [{
                            data: [
                                {{ $totalDiproses ?? 0 }}, 
                                {{ $totalSelesai ?? 0 }}, 
                                {{ $totalPending ?? 0 }}
                            ],
                            backgroundColor: ['#f59e0b', '#10b981', '#ef4444']
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, cutout: '65%' }
                });
            }

            // 4. Grafik Pelapor - Doughnut Status Laporan Saya Akurat dari Data
            const ctxPelaporDoughnut = document.getElementById('pelaporDoughnutChart')?.getContext('2d');
            if (ctxPelaporDoughnut) {
                new Chart(ctxPelaporDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: ['Diproses', 'Selesai', 'Menunggu'],
                        datasets: [{
                            data: [
                                {{ $statusDiproses ?? 0 }}, 
                                {{ $statusSelesai ?? 0 }}, 
                                {{ $statusMenunggu ?? 0 }}
                            ],
                            backgroundColor: ['#8b5cf6', '#10b981', '#f59e0b']
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, cutout: '65%' }
                });
            }
        });
    </script>
</x-app-layout>