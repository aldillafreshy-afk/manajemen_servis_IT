<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Ruangan') }}
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
                    <a href="{{ route('ruangan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Tambah Ruangan
                    </a>
                </div>

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Kode Ruangan</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama Ruangan</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangans as $index => $ruangan)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $ruangans->firstItem() + $index }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ruangan->kode_ruangan }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ruangan->nama_ruangan }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="{{ route('ruangan.edit', $ruangan->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('ruangan.destroy', $ruangan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada data ruangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $ruangans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>