<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Penugasan Teknisi') }}
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
                    <a href="{{ route('penugasan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Tugaskan Teknisi
                    </a>
                </div>

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-xs text-gray-700 uppercase">
                            <th class="border border-gray-300 px-3 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Perangkat / Ruangan</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Teknisi Bertugas</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Tgl Penugasan</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Catatan Admin</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Status</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($penugasans as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-3 py-2">{{ $penugasans->firstItem() + $index }}</td>
                                <td class="border border-gray-300 px-3 py-2">
                                    <strong>{{ $item->laporan->perangkat->nama_perangkat ?? '-' }}</strong><br>
                                    <span class="text-xs text-gray-500">{{ $item->laporan->ruangan->nama_ruangan ?? '-' }}</span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2">
                                    <span class="font-semibold text-blue-600">{{ $item->teknisi->name ?? '-' }}</span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_penugasan)->format('d M Y') }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2">{{ $item->catatan_admin ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    <span class="px-2 py-1 text-xs rounded font-bold 
                                        {{ $item->status_penugasan == 'selesai' ? 'bg-green-200 text-green-800' : ($item->status_penugasan == 'proses' ? 'bg-blue-200 text-blue-800' : ($item->status_penugasan == 'dibatalkan' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800')) }}">
                                        {{ ucfirst($item->status_penugasan) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    <a href="{{ route('penugasan.edit', $item->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('penugasan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus penugasan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada penugasan teknisi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $penugasans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>