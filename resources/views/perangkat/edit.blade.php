<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Perangkat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('perangkat.update', $perangkat->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kode Perangkat</label>
                        <input type="text" name="kode_perangkat" value="{{ old('kode_perangkat', $perangkat->kode_perangkat) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('kode_perangkat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Perangkat</label>
                        <input type="text" name="nama_perangkat" value="{{ old('nama_perangkat', $perangkat->nama_perangkat) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('nama_perangkat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Perangkat</label>
                        <input type="text" name="jenis_perangkat" value="{{ old('jenis_perangkat', $perangkat->jenis_perangkat) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('jenis_perangkat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Merk</label>
                        <input type="text" name="merk" value="{{ old('merk', $perangkat->merk) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('merk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Ruangan</label>
                        <select name="ruangan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}" {{ old('ruangan_id', $perangkat->ruangan_id) == $ruangan->id ? 'selected' : '' }}>
                                    {{ $ruangan->nama_ruangan }} ({{ $ruangan->kode_ruangan }})
                                </option>
                            @endforeach
                        </select>
                        @error('ruangan_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Pembelian</label>
                        <input type="date" name="tahun_pembelian" value="{{ old('tahun_pembelian', $perangkat->tahun_pembelian) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('tahun_pembelian') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <select name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="Aktif" {{ old('status', $perangkat->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="rusak" {{ old('status', $perangkat->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="servis" {{ old('status', $perangkat->status) == 'servis' ? 'selected' : '' }}>Servis</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update</button>
                        <a href="{{ route('perangkat.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>