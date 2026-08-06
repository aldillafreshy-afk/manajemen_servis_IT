<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Laporan Kerusakan') }}
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

                @if(Auth::user()->id_role == 3)
                <div class="mb-4">
                    <a href="{{ route('laporan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Buat Laporan Baru
                    </a>
                </div>
                @endif

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-xs text-gray-700 uppercase">
                            <th class="border border-gray-300 px-3 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Pelapor</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Perangkat / Ruangan</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Jenis Kerusakan</th>
                            <th class="border border-gray-300 px-3 py-2 text-left">Deskripsi</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Foto</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Urgensi</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Status</th>
                            <th class="border border-gray-300 px-3 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($laporans as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-3 py-2">{{ $laporans->firstItem() + $index }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $item->user->name ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2">
                                    <strong>{{ $item->perangkat->nama_perangkat ?? '-' }}</strong><br>
                                    <span class="text-xs text-gray-500">{{ $item->ruangan->nama_ruangan ?? '-' }}</span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2">{{ $item->jenisKerusakan->nama_kerusakan ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ Str::limit($item->deskripsi_kerusakan, 50) }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    @if($item->foto)
                                        <a href="{{ asset('storage/' . $item->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $item->foto) }}" class="w-12 h-12 object-cover rounded mx-auto border">
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    <span class="px-2 py-1 text-xs rounded font-bold 
                                        {{ $item->tingkat_urgensi == 'tinggi' ? 'bg-red-200 text-red-800' : ($item->tingkat_urgensi == 'sedang' ? 'bg-yellow-200 text-yellow-800' : 'bg-gray-200 text-gray-800') }}">
                                        {{ ucfirst($item->tingkat_urgensi) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    <span class="px-2 py-1 text-xs rounded font-bold 
                                        {{ $item->status == 'selesai' ? 'bg-green-200 text-green-800' : ($item->status == 'diproses' ? 'bg-blue-200 text-blue-800' : 'bg-yellow-200 text-yellow-800') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    <a href="{{ route('laporan.show', $item->id) }}" class="text-blue-600 hover:underline mr-2">
                                        <i class="fas fa-eye"></i> Detail </a>
                                    
                                    {{-- <a href="{{ route('laporan.edit', $item->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a> --}}
                                    <form action="{{ route('laporan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada laporan kerusakan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $laporans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>