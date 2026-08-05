<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Perangkat') }}
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
                    <a href="{{ route('perangkat.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Tambah Perangkat
                    </a>
                </div>

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Kode</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama Perangkat</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Jenis</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Merk</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Lokasi Ruangan</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Tahun Beli</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perangkats as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $perangkats->firstItem() + $index }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->kode_perangkat }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_perangkat }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->jenis_perangkat }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->merk }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->tahun_pembelian }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <span class="px-2 py-1 text-xs rounded font-bold 
                                        {{ $item->status == 'Aktif' ? 'bg-green-200 text-green-800' : ($item->status == 'rusak' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="{{ route('perangkat.edit', $item->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('perangkat.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada data perangkat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $perangkats->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>