<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jenis Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('jenis-kerusakan.update', $jenisKerusakan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Biaya (Rp)</label>
                        <input type="text" name="biaya" value="{{ old('biaya', number_format($tindakan->biaya, 0, '', '')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('biaya') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update</button>
                        <a href="{{ route('jenis-kerusakan.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>