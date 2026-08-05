<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Perubahan Status Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-4 flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        Catatan audit trail seluruh perubahan status pada laporan kerusakan perangkat.
                    </p>
                    @if(request('laporan_id'))
                        <a href="{{ route('riwayat-status.index') }}" class="text-xs bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-3 rounded">
                            Reset Filter (Tampilkan Semua)
                        </a>
                    @endif
                </div>

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-xs text-gray-700 uppercase">
                            <th class="border border-gray-300 px-3 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Waktu Log</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Laporan / Perangkat</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Status Lama</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Status Baru</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Oleh (User)</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($riwayats as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-3 py-2">{{ $riwayats->firstItem() + $index }}</td>
                                <td class="border border-gray-300 px-3 py-2 whitespace-nowrap text-xs">
                                    {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2">
                                    <strong>[#{{ $item->laporan_id }}] {{ $item->laporan->perangkat->nama_perangkat ?? '-' }}</strong><br>
                                    <span class="text-xs text-gray-500">{{ $item->laporan->ruangan->nama_ruangan ?? '-' }}</span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    @if($item->status_lama)
                                        <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700 font-semibold">
                                            {{ ucfirst($item->status_lama) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    <span class="px-2 py-1 text-xs rounded font-bold 
                                        {{ $item->status_baru == 'selesai' ? 'bg-green-200 text-green-800' : ($item->status_baru == 'diproses' ? 'bg-blue-200 text-blue-800' : ($item->status_baru == 'dibatalkan' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800')) }}">
                                        {{ ucfirst($item->status_baru) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2 font-semibold text-blue-600">
                                    {{ $item->user->name ?? 'Sistem' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-xs">
                                    {{ $item->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada riwayat perubahan status.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $riwayats->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>