<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Tugas Perbaikan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Tugas Penanganan Kerusakan Perangkat</h3>
                    <p class="text-sm text-gray-600">Seluruh tugas perbaikan yang ditugaskan kepada akun Anda.</p>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($penugasans as $tugas)
                        <div class="border rounded-lg p-5 shadow-sm hover:shadow-md transition bg-gray-50 border-gray-200 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded {{ ($tugas->laporan->tingkat_urgensi ?? '') == 'tinggi' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        Urgensi: {{ ucfirst($tugas->laporan->tingkat_urgensi ?? 'Normal') }}
                                    </span>
                                    <span class="px-2.5 py-1 text-xs font-bold rounded {{ $tugas->status_penugasan == 'selesai' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($tugas->status_penugasan) }}
                                    </span>
                                </div>

                                <h4 class="text-lg font-bold text-gray-800">
                                    {{ $tugas->laporan->perangkat->nama_perangkat ?? 'Perangkat Tidak Ditemukan' }}
                                </h4>

                                <div class="text-sm text-gray-600 space-y-1 my-3">
                                    <p>📍 <strong>Ruangan:</strong> {{ $tugas->laporan->ruangan->nama_ruangan ?? '-' }}</p>
                                    <p>🛠️ <strong>Kerusakan:</strong> {{ $tugas->laporan->jenisKerusakan->nama_kerusakan ?? '-' }}</p>
                                    <p>📅 <strong>Tgl Penugasan:</strong> {{ \Carbon\Carbon::parse($tugas->tanggal_penugasan)->format('d M Y') }}</p>
                                    <div class="pt-2 text-gray-700 text-xs italic bg-white p-3 rounded border border-gray-200">
                                        "{{ $tugas->laporan->deskripsi_kerusakan ?? 'Tidak ada deskripsi' }}"
                                    </div>
                                    @if($tugas->catatan_admin)
                                        <p class="text-xs text-blue-600 pt-1"><strong>Catatan Admin:</strong> {{ $tugas->catatan_admin }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-3 border-t border-gray-200 flex justify-between items-center mt-2">
                                <span class="text-xs text-gray-400">ID Laporan: #{{ $tugas->laporan_id }}</span>
                                
                                @if($tugas->status_penugasan != 'selesai')
                                    <a href="{{ route('tindakan-perbaikan.create', ['penugasan_id' => $tugas->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded shadow transition">
                                        + Input Perbaikan
                                    </a>
                                @else
                                    <span class="text-xs font-bold text-green-600 flex items-center gap-1">
                                        ✓ Selesai Dikerjakan
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-10 text-gray-500 bg-gray-50 rounded-lg border border-dashed">
                            📁 Belum ada penugasan perbaikan untuk Anda saat ini.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $penugasans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>