<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Penugasan Teknisi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('penugasan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Laporan Kerusakan</label>
                        <select name="laporan_id" class="...">
                            <option value="">-- Pilih Laporan Kerusakan --</option>
                            @forelse($laporans as $laporan)
                                <option value="{{ $laporan->id }}">
                                    [ID: #{{ $laporan->id }}] {{ $laporan->perangkat->nama_perangkat ?? 'Perangkat Tidak Ditemukan' }} - {{ $laporan->deskripsi_kerusakan }}
                                </option>
                            @empty
                                <option value="" disabled>-- Tidak ada laporan baru yang perlu ditugaskan --</option>
                            @endforelse
                        </select>
                        @error('laporan_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Teknisi</label>
                        <select name="teknisi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">-- Pilih Teknisi --</option>
                            @foreach($teknisis as $teknisi)
                                <option value="{{ $teknisi->id }}" {{ old('teknisi_id') == $teknisi->id ? 'selected' : '' }}>
                                    {{ $teknisi->name }} ({{ $teknisi->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('teknisi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Penugasan</label>
                        <input type="date" name="tanggal_penugasan" value="{{ old('tanggal_penugasan', date('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('tanggal_penugasan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Catatan Admin <span class="text-xs text-gray-500 font-normal">(Opsional)</span></label>
                        <textarea name="catatan_admin" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Instruksi khusus untuk teknisi...">{{ old('catatan_admin') }}</textarea>
                        @error('catatan_admin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Penugasan</button>
                        <a href="{{ route('penugasan.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>