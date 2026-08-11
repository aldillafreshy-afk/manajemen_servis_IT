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

                <!-- ===== FORM FILTER ===== -->
                <form method="GET" action="{{ route('laporan.index') }}" class="mb-6">
                    
                    <!-- BARIS 1: Cari, Status, Urgensi -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">🔍 Cari</label>
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}" 
                                   placeholder="Cari pelapor, perangkat, jenis atau status..."
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">📊 Status</label>
                            <select name="status" 
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2">
                                <option value="">Semua Status</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">⚡ Urgensi</label>
                            <select name="tingkat_urgensi" 
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2">
                                <option value="">Semua Urgensi</option>
                                <option value="rendah" {{ request('tingkat_urgensi') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="sedang" {{ request('tingkat_urgensi') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="tinggi" {{ request('tingkat_urgensi') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <!-- BARIS 2: Perangkat, Ruangan, Jenis Kerusakan, Tombol -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">💻 Perangkat</label>
                            <select name="perangkat_id" 
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2">
                                <option value="">Semua Perangkat</option>
                                @foreach($perangkats as $perangkat)
                                    <option value="{{ $perangkat->id }}" {{ request('perangkat_id') == $perangkat->id ? 'selected' : '' }}>
                                        {{ $perangkat->nama_perangkat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">📍 Ruangan</label>
                            <select name="ruangan_id" 
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2">
                                <option value="">Semua Ruangan</option>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ request('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">🔧 Jenis Kerusakan</label>
                            <select name="jenis_kerusakan_id" 
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2">
                                <option value="">Semua Jenis</option>
                                @foreach($jenisKerusakans as $jenis)
                                    <option value="{{ $jenis->id }}" {{ request('jenis_kerusakan_id') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_kerusakan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari
                            </button>
                        </div>
                        <div class="flex items-end">
                            <a href="{{ route('laporan.index') }}" 
                               class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </div>

                    <!-- Informasi Filter Aktif -->
                    @if(request()->anyFilled(['q', 'status', 'tingkat_urgensi', 'perangkat_id', 'ruangan_id', 'jenis_kerusakan_id']))
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="text-xs text-gray-500">Filter aktif:</span>
                            @if(request('q'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Cari: {{ request('q') }}
                                </span>
                            @endif
                            @if(request('status'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Status: {{ ucfirst(request('status')) }}
                                </span>
                            @endif
                            @if(request('tingkat_urgensi'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Urgensi: {{ ucfirst(request('tingkat_urgensi')) }}
                                </span>
                            @endif
                            @if(request('perangkat_id'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Perangkat: {{ $perangkats->find(request('perangkat_id'))->nama_perangkat ?? '' }}
                                </span>
                            @endif
                            @if(request('ruangan_id'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Ruangan: {{ $ruangans->find(request('ruangan_id'))->nama_ruangan ?? '' }}
                                </span>
                            @endif
                            @if(request('jenis_kerusakan_id'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    Jenis: {{ $jenisKerusakans->find(request('jenis_kerusakan_id'))->nama_kerusakan ?? '' }}
                                </span>
                            @endif
                        </div>
                    @endif
                </form>

                <!-- ===== TABEL LAPORAN ===== -->
                <div class="overflow-x-auto">
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
                                <tr class="hover:bg-gray-50">
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
                                        <div class="flex flex-col items-center gap-1">
                                            <a href="{{ route('laporan.show', $item->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('laporan.pdf', $item->id) }}" 
                                               class="text-red-600 hover:text-red-800 text-xs font-medium" 
                                               title="Download PDF">
                                                <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                PDF
                                            </a>
                                            <form action="{{ route('laporan.destroy', $item->id) }}" 
                                                  method="POST" 
                                                  class="inline" 
                                                  onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                        Belum ada laporan kerusakan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- ===== PAGINATION ===== -->
                <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $laporans->firstItem() }} sampai {{ $laporans->lastItem() }} 
                        dari {{ $laporans->total() }} data
                    </div>
                    <div>
                        {{ $laporans->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>