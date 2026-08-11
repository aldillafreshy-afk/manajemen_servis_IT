<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekap Laporan Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Form Filter -->
                <form method="GET" action="{{ route('rekap.laporan.index') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Awal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                @foreach($statusList as $st)
                                    <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                        {{ ucfirst($st) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Perangkat</label>
                            <select name="perangkat_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Perangkat</option>
                                @foreach($perangkatList as $perangkat)
                                    <option value="{{ $perangkat->id }}" {{ request('perangkat_id') == $perangkat->id ? 'selected' : '' }}>
                                        {{ $perangkat->nama_perangkat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('rekap.laporan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                        <a href="{{ route('rekap.laporan.pdf', request()->all()) }}" 
                           class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-auto">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>
                    </div>
                </form>

                <!-- Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-100 p-4 rounded-lg">
                        <div class="text-sm text-blue-600">Total Laporan</div>
                        <div class="text-2xl font-bold text-blue-800">{{ $laporans->total() }}</div>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg">
                        <div class="text-sm text-green-600">Selesai</div>
                        <div class="text-2xl font-bold text-green-800">
                            {{ $laporans->where('status', 'selesai')->count() }}
                        </div>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg">
                        <div class="text-sm text-yellow-600">Diproses</div>
                        <div class="text-2xl font-bold text-yellow-800">
                            {{ $laporans->where('status', 'diproses')->count() }}
                        </div>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <div class="text-sm text-gray-600">Menunggu</div>
                        <div class="text-2xl font-bold text-gray-800">
                            {{ $laporans->where('status', 'menunggu')->count() }}
                        </div>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-xs text-gray-700 uppercase">
                                <th class="border border-gray-300 px-3 py-2 text-left">No</th>
                                <th class="border border-gray-300 px-3 py-2 text-left">No. Laporan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left">Pelapor</th>
                                <th class="border border-gray-300 px-3 py-2 text-left">Perangkat</th>
                                <th class="border border-gray-300 px-3 py-2 text-left">Ruangan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left">Jenis Kerusakan</th>
                                <th class="border border-gray-300 px-3 py-2 text-center">Tanggal</th>
                                <th class="border border-gray-300 px-3 py-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporans as $index => $item)
                                <tr>
                                    <td class="border border-gray-300 px-3 py-2">{{ $laporans->firstItem() + $index }}</td>
                                    <td class="border border-gray-300 px-3 py-2 font-medium">{{ $item->no_laporan ?? 'LP-'.$item->id }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $item->user->name ?? '-' }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $item->perangkat->nama_perangkat ?? '-' }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $item->jenisKerusakan->nama_kerusakan ?? '-' }}</td>
                                    <td class="border border-gray-300 px-3 py-2 text-center">{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td class="border border-gray-300 px-3 py-2 text-center">
                                        <span class="px-2 py-1 text-xs rounded font-bold 
                                            {{ $item->status == 'selesai' ? 'bg-green-200 text-green-800' : 
                                               ($item->status == 'diproses' ? 'bg-blue-200 text-blue-800' : 
                                               'bg-yellow-200 text-yellow-800') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                        Tidak ada data laporan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $laporans->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>