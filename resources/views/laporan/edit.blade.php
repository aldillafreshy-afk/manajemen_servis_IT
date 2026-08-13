<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit / Tanggapi Laporan Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status Penanganan</label>
                        <select name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 font-bold leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="menunggu" {{ old('status', $laporan->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ old('status', $laporan->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ old('status', $laporan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Perangkat</label>
                        <select id="perangkat_id" name="perangkat_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @foreach($perangkats as $p)
                                <option value="{{ $p->id }}" {{ old('perangkat_id', $laporan->perangkat_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_perangkat }} ({{ $p->kode_perangkat }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Ruangan</label>
                        <select id="ruangan_id" name="ruangan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @foreach($ruangans as $r)
                                <option value="{{ $r->id }}" {{ old('ruangan_id', $laporan->ruangan_id) == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kerusakan</label>
                        <select name="jenis_kerusakan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @foreach($jenisKerusakans as $j)
                                <option value="{{ $j->id }}" {{ old('jenis_kerusakan_id', $laporan->jenis_kerusakan_id) == $j->id ? 'selected' : '' }}>
                                    {{ $j->nama_kerusakan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tingkat Urgensi</label>
                        <select name="tingkat_urgensi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="rendah" {{ old('tingkat_urgensi', $laporan->tingkat_urgensi) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ old('tingkat_urgensi', $laporan->tingkat_urgensi) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ old('tingkat_urgensi', $laporan->tingkat_urgensi) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Kerusakan</label>
                        <textarea name="deskripsi_kerusakan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('deskripsi_kerusakan', $laporan->deskripsi_kerusakan) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Foto Bukti <span class="text-xs text-gray-500 font-normal">(Biarkan kosong jika tidak diubah)</span></label>
                        <input type="file" name="foto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @if($laporan->foto)
                            <div class="mt-2">
                                <span class="text-xs text-gray-500">Foto Saat Ini:</span><br>
                                <img src="{{ asset('storage/' . $laporan->foto) }}" class="w-20 h-20 object-cover rounded border">
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update Laporan</button>
                        <a href="{{ route('laporan.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Cascading dropdown: Perangkat berdasarkan Ruangan
        const ruanganSelect = document.getElementById('ruangan_id');
        const perangkatSelect = document.getElementById('perangkat_id');
        const perangkatValue = document.getElementById('perangkat_id').value;

        // Function untuk fetch perangkat berdasarkan ruangan
        function loadPerangkatByRuangan(ruanganId) {
            if (!ruanganId) {
                // Reset dropdown jika tidak ada ruangan yang dipilih
                perangkatSelect.innerHTML = '<option value="">-- Pilih Perangkat --</option>';
                return;
            }

            // Fetch perangkat dari API
            fetch(`/api/perangkat-by-ruangan/${ruanganId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear existing options
                    perangkatSelect.innerHTML = '<option value="">-- Pilih Perangkat --</option>';
                    
                    // Add new options
                    data.forEach(perangkat => {
                        const option = document.createElement('option');
                        option.value = perangkat.id;
                        option.textContent = `${perangkat.kode_perangkat} - ${perangkat.nama_perangkat}`;
                        
                        // Set as selected jika sesuai dengan old value
                        if (perangkat.id == perangkatValue) {
                            option.selected = true;
                        }
                        
                        perangkatSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading perangkat:', error));
        }

        // Load perangkat saat halaman pertama kali dibuka (jika ada ruangan yang sudah dipilih)
        if (ruanganSelect.value) {
            loadPerangkatByRuangan(ruanganSelect.value);
        }

        // Load perangkat ketika user mengubah pilihan ruangan
        ruanganSelect.addEventListener('change', function() {
            loadPerangkatByRuangan(this.value);
        });
    </script>
</x-app-layout>