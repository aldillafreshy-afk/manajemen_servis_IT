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
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Log Audit Status</h3>
                        <p class="text-sm text-gray-600">
                            Catatan riwayat perubahan status laporan dari awal dibuat hingga selesai diperbaiki.
                        </p>
                    </div>
                    
                    @if(request('laporan_id'))
                        <a href="{{ route('riwayat-status.index') }}" class="text-xs bg-gray-500 hover:bg-gray-700 text-white font-bold py-1.5 px-3 rounded shadow">
                            &larr; Tampilkan Semua Riwayat
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-xs text-gray-700 uppercase tracking-wider">
                                <th class="border border-gray-300 px-3 py-2.5 text-center">No</th>
                                <th class="border border-gray-300 px-3 py-2.5 text-left">Waktu Log</th>
                                <th class="border border-gray-300 px-3 py-2.5 text-left">Laporan / Perangkat</th>
                                <th class="border border-gray-300 px-3 py-2.5 text-center">Status Lama</th>
                                <th class="border border-gray-300 px-3 py-2.5 text-center">Status Baru</th>
                                <th class="border border-gray-300 px-3 py-2.5 text-left">Diubah Oleh</th>
                                <th class="border border-gray-300 px-3 py-2.5 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-200">
                            @forelse($riwayats as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-3 py-2 text-center text-gray-600">
                                        {{ $riwayats->firstItem() + $index }}
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 whitespace-nowrap text-xs text-gray-600">
                                        {{ $item->created_at ? $item->created_at->format('d M Y - H:i') : '-' }} WIB
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <div class="font-bold text-gray-800">
                                            [#{{ $item->laporan_id }}] {{ $item->laporan->perangkat->nama_perangkat ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Ruangan: {{ $item->laporan->ruangan->nama_ruangan ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-center whitespace-nowrap">
                                        @if($item->status_lama)
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-700">
                                                {{ ucfirst($item->status_lama) }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400 italic">(Awal)</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-center whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-bold rounded 
                                            {{ $item->status_baru == 'selesai' ? 'bg-green-100 text-green-800 border border-green-300' : ($item->status_baru == 'diproses' ? 'bg-blue-100 text-blue-800 border border-blue-300' : ($item->status_baru == 'dibatalkan' ? 'bg-red-100 text-red-800 border border-red-300' : 'bg-yellow-100 text-yellow-800 border border-yellow-300')) }}">
                                            {{ ucfirst($item->status_baru) }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 whitespace-nowrap font-medium text-blue-700">
                                        {{ $item->user->name ?? 'Sistem' }}
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-xs text-gray-600">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                        Belum ada riwayat perubahan status.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $riwayats->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>