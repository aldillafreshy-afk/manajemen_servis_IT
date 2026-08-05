<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tindakan Perbaikan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('tindakan-perbaikan.update', $tindakan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Tindakan yang Dilakukan</label>
                        <textarea name="deskripsi_tindakan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('deskripsi_tindakan', $tindakan->deskripsi_tindakan) }}</textarea>
                        @error('deskripsi_tindakan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $tindakan->tanggal_mulai) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('tanggal_mulai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $tindakan->tanggal_selesai) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('tanggal_selesai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status Hasil</label>
                            <select name="status_hasil" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="proses" {{ old('status_hasil', $tindakan->status_hasil) == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="berhasil" {{ old('status_hasil', $tindakan->status_hasil) == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                                <option value="pending_sparepart" {{ old('status_hasil', $tindakan->status_hasil) == 'pending_sparepart' ? 'selected' : '' }}>Pending Sparepart</option>
                                <option value="gagal_diperbaiki" {{ old('status_hasil', $tindakan->status_hasil) == 'gagal_diperbaiki' ? 'selected' : '' }}>Gagal Diperbaiki</option>
                            </select>
                            @error('status_hasil') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Biaya (Rp)</label>
                            <input type="number" name="biaya" value="{{ old('biaya', $tindakan->biaya) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('biaya') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Catatan Teknisi</label>
                        <textarea name="catatan_teknisi" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('catatan_teknisi', $tindakan->catatan_teknisi) }}</textarea>
                        @error('catatan_teknisi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update Tindakan</button>
                        <a href="{{ route('tindakan-perbaikan.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>