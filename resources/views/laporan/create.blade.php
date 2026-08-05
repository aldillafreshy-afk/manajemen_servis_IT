<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Laporan Kerusakan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('laporan.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- 1. Pilih Ruangan -->
                    <div>
                        <label for="ruangan_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Lokasi / Ruangan <span class="text-red-500">*</span>
                        </label>
                        <select name="ruangan_id" id="ruangan_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Lokasi Ruangan --</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                    {{ $ruangan->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 2. Pilih Perangkat -->
                    <div>
                        <label for="perangkat_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Perangkat yang Rusak <span class="text-red-500">*</span>
                        </label>
                        <select name="perangkat_id" id="perangkat_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Perangkat --</option>
                            @foreach($perangkats as $perangkat)
                                <option value="{{ $perangkat->id }}" {{ old('perangkat_id') == $perangkat->id ? 'selected' : '' }}>
                                    {{ $perangkat->nama_perangkat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Pilih Jenis Kerusakan -->
                    <div>
                        <label for="jenis_kerusakan_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori Kerusakan <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kerusakan_id" id="jenis_kerusakan_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Jenis Kerusakan --</option>
                            @foreach($jenisKerusakans as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_kerusakan_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama_kerusakan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 4. Deskripsi Kerusakan -->
                    <div>
                        <label for="deskripsi_kerusakan" class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi Detail Kerusakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi_kerusakan" id="deskripsi_kerusakan" rows="4" required placeholder="Jelaskan kendala/kerusakan yang terjadi..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('deskripsi_kerusakan') }}</textarea>
                    </div>

                    <!-- 5. Tingkat Urgensi -->
                    <div>
                        <label for="tingkat_urgensi" class="block text-sm font-medium text-gray-700 mb-1">Tingkat Urgensi</label>
                        <select name="tingkat_urgensi" id="tingkat_urgensi" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="rendah">Rendah (Bisa ditunda)</option>
                            <option value="sedang" selected>Sedang (Normal)</option>
                            <option value="tinggi">Tinggi (Mendesak)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Kerusakan</label><br>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                id="foto" name="foto" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        <small class="text-muted">Format: JPEG, PNG, JPG. Maksimal 2MB</small>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('laporan.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold py-2.5 px-4 rounded shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2.5 px-5 rounded shadow">
                            Kirim Laporan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>