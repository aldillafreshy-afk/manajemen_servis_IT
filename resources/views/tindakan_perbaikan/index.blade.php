<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Tindakan Perbaikan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('tindakan-perbaikan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Catat Tindakan Perbaikan
                    </a>
                </div>

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-xs text-gray-700 uppercase">
                            <th class="border border-gray-300 px-3 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Perangkat & Teknisi</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Tindakan</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Tgl Kerja</th>
                            <th class="border border-gray-300 px-3 py-2 text-right">Biaya</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Hasil</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($tindakans as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-3 py-2">{{ $tindakans->firstItem() + $index }}</td>
                                <td class="border border-gray-300 px-3 py-2">
                                    <strong>{{ $item->penugasan->laporan->perangkat->nama_perangkat ?? '-' }}</strong><br>
                                    <span class="text-xs text-blue-600">Teknisi: {{ $item->penugasan->teknisi->name ?? '-' }}</span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2">{{ $item->deskripsi_tindakan }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center text-xs">
                                    Mulai: {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}<br>
                                    Selesai: {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-right font-mono">
                                    Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    <span class="px-2 py-1 text-xs rounded font-bold 
                                        {{ $item->status_hasil == 'berhasil' ? 'bg-green-200 text-green-800' : ($item->status_hasil == 'proses' ? 'bg-blue-200 text-blue-800' : ($item->status_hasil == 'pending_sparepart' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800')) }}">
                                        {{ str_replace('_', ' ', ucfirst($item->status_hasil)) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    <a href="{{ route('tindakan-perbaikan.edit', $item->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('tindakan-perbaikan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data tindakan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada catatan tindakan perbaikan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $tindakans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>