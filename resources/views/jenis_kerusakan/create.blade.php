<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jenis Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('jenis-kerusakan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_kerusakan">
                            Nama Jenis Kerusakan
                        </label>
                        {{-- Sesuaikan attribute 'name' di bawah ini dengan nama kolom di tabel database kamu --}}
                        <input type="text" name="nama_kerusakan" id="nama_kerusakan" value="{{ old('nama_kerusakan') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Hardware, Software, Jaringan, dll." required>
                        @error('nama_kerusakan') 
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="deskripsi">
                            Deskripsi <span class="text-xs text-gray-500 font-normal">(Opsional)</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Keterangan singkat tentang jenis kerusakan ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') 
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Data
                        </button>
                        <a href="{{ route('jenis-kerusakan.index') }}" class="text-gray-600 hover:text-gray-800 hover:underline text-sm font-bold">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>