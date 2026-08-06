<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tugas Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Laporan Kerusakan #{{ $tugas->laporan_id }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Ditugaskan pada: {{ \Carbon\Carbon::parse($tugas->tanggal_penugasan)->format('d M Y') }}</p>
                    </div>
                    <a href="{{ route('teknisi.tugas') }}" class="text-sm text-blue-600 hover:underline">Kembali ke Tugas Saya</a>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Informasi Pelapor</h4>
                        <p class="text-sm text-gray-800"><strong>Nama Pelapor:</strong> {{ $tugas->laporan->user->name ?? '-' }}</p>
                        <p class="text-sm text-gray-800"><strong>Perangkat:</strong> {{ $tugas->laporan->perangkat->nama_perangkat ?? '-' }}</p>
                        <p class="text-sm text-gray-800"><strong>Ruangan:</strong> {{ $tugas->laporan->ruangan->nama_ruangan ?? '-' }}</p>
                        <p class="text-sm text-gray-800"><strong>Jenis Kerusakan:</strong> {{ $tugas->laporan->jenisKerusakan->nama_kerusakan ?? '-' }}</p>
                        <p class="text-sm text-gray-800"><strong>Tingkat Urgensi:</strong> {{ ucfirst($tugas->laporan->tingkat_urgensi ?? '-') }}</p>
                        <p class="text-sm text-gray-800"><strong>Status Laporan:</strong> {{ ucfirst($tugas->laporan->status ?? '-') }}</p>
                        <p class="text-sm text-gray-800"><strong>Waktu Pelaporan:</strong> {{ \Carbon\Carbon::parse($tugas->laporan->tanggal_lapor)->format('d M Y H:i') }}</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Deskripsi Pelapor</h4>
                        <div class="text-sm text-gray-800 whitespace-pre-wrap bg-white p-4 rounded border border-gray-200">
                            {{ $tugas->laporan->deskripsi_kerusakan ?? 'Tidak ada deskripsi' }}
                        </div>

                        @if($tugas->laporan->foto)
                            <div class="mt-4">
                                <h5 class="text-sm font-semibold text-gray-700 mb-2">Foto Pelaporan</h5>
                                <a href="{{ asset('storage/' . $tugas->laporan->foto) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $tugas->laporan->foto) }}" alt="Foto Laporan" class="w-full rounded-lg border border-gray-200 object-cover" />
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Catatan Tugas Admin</h4>
                    <p class="text-sm text-gray-800">{{ $tugas->catatan_admin ?? 'Tidak ada catatan admin' }}</p>
                </div>

                <div class="mt-6 flex flex-wrap gap-3 items-center">
                    <a href="{{ route('penugasan.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Kembali
                    </a>
                    @if($tugas->status_penugasan != 'selesai')
                        <a href="{{ route('tindakan-perbaikan.create', ['penugasan_id' => $tugas->id]) }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                            Input Tindakan Perbaikan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
