<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pengguna / User') }}
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
                    <a href="{{ route('user.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Tambah User
                    </a>
                </div>

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">No HP</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Role</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $users->firstItem() + $index }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->email }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->phone ?? '-' }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <span class="px-2 py-1 text-xs rounded font-bold bg-blue-100 text-blue-800">
                                        {{ $item->role->nama ?? 'Belum ada role' }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="{{ route('user.edit', $item->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>