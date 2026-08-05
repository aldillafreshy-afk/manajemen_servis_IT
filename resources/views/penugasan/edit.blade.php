<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Penugasan Teknisi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('penugasan.update', $penugasan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Teknisi</label>
                        <select name="teknisi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @foreach($teknisis as $teknisi)
                                <option value="{{ $teknisi->id }}" {{ old('teknisi_id', $penugasan->teknisi_id) == $teknisi->id ? 'selected' : '' }}>
                                    {{ $teknisi->name }} ({{ $teknisi->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('teknisi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Penugasan</label>
                        <input type="date" name="tanggal_penugasan" value="{{ old('tanggal_penugasan', $penugasan->tanggal_penugasan) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('tanggal_penugasan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status Penugasan</label>
                        <select name="status_penugasan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="ditugaskan" {{ old('status_penugasan', $penugasan->status_penugasan) == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
                            <option value="proses" {{ old('status_penugasan', $penugasan->status_penugasan) == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ old('status_penugasan', $penugasan->status_penugasan) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status_penugasan', $penugasan->status_penugasan) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status_penugasan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Catatan Admin</label>
                        <textarea name="catatan_admin" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('catatan_admin', $penugasan->catatan_admin) }}</textarea>
                        @error('catatan_admin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update Penugasan</button>
                        <a href="{{ route('penugasan.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>