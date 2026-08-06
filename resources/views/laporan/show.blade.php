<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Laporan Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Tombol Kembali -->
                <div class="mb-4">
                    <a href="{{ route('laporan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                        ← Kembali ke Daftar Laporan
                    </a>
                </div>

                <!-- Informasi Laporan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi Laporan</h3>
                        
                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">ID Laporan</label>
                            <p class="text-gray-800 font-medium">#{{ $laporan->id }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Pelapor</label>
                            <p class="text-gray-800">{{ $laporan->user->name ?? 'Tidak diketahui' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Tanggal Laporan</label>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Status</label>
                            <p>
                                <span class="px-2 py-1 text-xs rounded font-bold 
                                    {{ $laporan->status == 'selesai' ? 'bg-green-200 text-green-800' : ($laporan->status == 'diproses' ? 'bg-blue-200 text-blue-800' : 'bg-yellow-200 text-yellow-800') }}">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Tingkat Urgensi</label>
                            <p>
                                <span class="px-2 py-1 text-xs rounded font-bold 
                                    {{ $laporan->tingkat_urgensi == 'tinggi' ? 'bg-red-200 text-red-800' : ($laporan->tingkat_urgensi == 'sedang' ? 'bg-yellow-200 text-yellow-800' : 'bg-gray-200 text-gray-800') }}">
                                    {{ ucfirst($laporan->tingkat_urgensi) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Detail Perangkat & Ruangan</h3>
                        
                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Perangkat</label>
                            <p class="text-gray-800 font-medium">{{ $laporan->perangkat->nama_perangkat ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $laporan->perangkat->kode_perangkat ?? '' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Ruangan</label>
                            <p class="text-gray-800">{{ $laporan->ruangan->nama_ruangan ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Jenis Kerusakan</label>
                            <p class="text-gray-800">{{ $laporan->jenisKerusakan->nama_kerusakan ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Foto Bukti</label>
                            @if($laporan->foto)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $laporan->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $laporan->foto) }}" 
                                             alt="Foto Kerusakan"
                                             class="w-32 h-32 object-cover rounded border hover:opacity-75 transition">
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Tidak ada foto</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Kerusakan -->
                <div class="mt-6 border-t pt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Deskripsi Kerusakan</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $laporan->deskripsi_kerusakan }}</p>
                    </div>
                </div>

                <!-- Riwayat Status -->
                @if(isset($riwayatStatus) && $riwayatStatus->count() > 0)
                <div class="mt-6 border-t pt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Riwayat Perubahan Status</h3>
                    <div class="space-y-2">
                        @foreach($riwayatStatus as $riwayat)
                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg text-sm">
                                <div>
                                    <span class="font-medium">{{ $riwayat->user->name ?? 'Sistem' }}</span>
                                    <span class="text-gray-500">mengubah status dari</span>
                                    <span class="px-2 py-0.5 bg-yellow-200 text-yellow-800 rounded text-xs">{{ $riwayat->status_lama }}</span>
                                    <span class="text-gray-500">→</span>
                                    <span class="px-2 py-0.5 bg-blue-200 text-blue-800 rounded text-xs">{{ $riwayat->status_baru }}</span>
                                </div>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($riwayat->created_at)->diffForHumans() }}</span>
                            </div>
                            @if($riwayat->keterangan)
                                <p class="text-xs text-gray-500 pl-4">{{ $riwayat->keterangan }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tombol Aksi -->
                {{-- <div class="mt-6 border-t pt-6 flex justify-end space-x-3">
                    <a href="{{ route('laporan.edit', $laporan->id) }}" 
                       class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-sm">
                        Edit Laporan
                    </a>
                    <form action="{{ route('laporan.destroy', $laporan->id) }}" 
                          method="POST" 
                          class="inline-block" 
                          onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                            Hapus Laporan
                        </button>
                    </form>
                </div> --}}

            </div>
        </div>
    </div>
</x-app-layout>