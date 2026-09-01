<!-- SIDEBAR FIXLY -->
<aside 
    class="w-64 bg-[#1e293b] text-white flex flex-col fixed lg:relative left-0 top-0 h-screen z-40 lg:z-0 lg:min-h-screen transition-transform duration-300 shrink-0 shadow-lg"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <!-- Logo & Brand (Fixed at Top) -->
    <div class="shrink-0 p-6 flex flex-col items-center border-b border-slate-700/50">
        <img src="{{ asset('images/tes.png') }}" alt="Fixly Logo" class="h-[100px] w-auto object-contain mb-2">
        <span class="text-[10px] text-gray-400 tracking-widest uppercase">FIX IT. SOLVE IT. SIMPLE.</span>
    </div>

    <!-- Dashboard Link (Fixed Below Logo) -->
    <div class="shrink-0 px-4 mt-6">
        <a href="{{ route('dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm shadow-md transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'bg-slate-800 text-gray-300 hover:bg-slate-700 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 00-1 1m-6 0h6"></path></svg>
            <span>Dashboard</span>
        </a>
    </div>

    <!-- Navigation Links (Scrollable di Mobile Only) -->
    <nav class="flex-1 px-4 mt-6 space-y-5 text-sm overflow-y-auto lg:overflow-visible">
        @auth
            @php
                $roleUser = Auth::user()->role;
                if (is_object($roleUser) || is_array($roleUser)) {
                    $roleName = strtolower($roleUser['nama'] ?? $roleUser->nama ?? '');
                } else {
                    $roleName = strtolower($roleUser ?? '');
                }
            @endphp

            <!-- ================= 1. ROLE ADMIN ================= -->
            @if($roleName === 'admin')
                <div>
                    <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2 px-2">MASTER DATA</div>
                    <div class="space-y-1">
                        <a href="{{ route('perangkat.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('perangkat.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Data Perangkat
                        </a>
                        <a href="{{ route('ruangan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('ruangan.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Data Ruangan
                        </a>
                        <a href="{{ route('user.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('user.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Data Teknisi / User
                        </a>
                        <a href="{{ route('jenis-kerusakan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('jenis-kerusakan.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Jenis Kerusakan
                        </a>
                        <a href="{{ route('role.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('role.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Data Role
                        </a>
                    </div>
                </div>

                <div>
                    <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2 px-2">TRANSAKSI</div>
                    <div class="space-y-1">
                        <a href="{{ route('laporan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('laporan.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Laporan Kerusakan
                        </a>
                        <a href="{{ route('penugasan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('penugasan.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Penugasan Teknisi
                        </a>
                        <a href="{{ route('tindakan-perbaikan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('tindakan-perbaikan.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Proses Perbaikan
                        </a>
                        <a href="{{ route('riwayat-status.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('riwayat-status.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            Riwayat Servis
                        </a>
                        <a href="{{ route('rekap.laporan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('rekap.laporan.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-file-alt"></i> Rekap Laporan
                        </a>
                    </div>
                </div>

            <!-- ================= 2. ROLE TEKNISI ================= -->
            @elseif($roleName === 'teknisi')
                <div class="space-y-1">
                    <a href="{{ route('penugasan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('penugasan.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                        Tugas Saya
                    </a>
                    <a href="{{ route('tindakan-perbaikan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('tindakan-perbaikan.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                        Proses Perbaikan
                    </a>
                    <a href="{{ route('riwayat-status.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('riwayat-status.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                        Riwayat Servis
                    </a>
                    <a href="{{ route('perangkat.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('perangkat.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                        Data Perangkat
                    </a>
                </div>

            <!-- ================= 3. ROLE PELAPOR ================= -->
            @elseif($roleName === 'pelapor' || $roleName === 'user')
                <div class="space-y-1">
                    <a href="{{ route('laporan.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('laporan.index') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                        Laporan Saya
                    </a>
                    <a href="{{ route('laporan.create') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('laporan.create') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                        + Buat Laporan
                    </a>
                    <a href="{{ route('riwayat-status.index') }}" class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('riwayat-status.*') ? 'bg-blue-600/30 text-blue-400 font-semibold border-l-4 border-blue-500 pl-2' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                        Riwayat Servis
                    </a>
                </div>
            @endif
        @endauth
    </nav>

    <!-- Log Out (Fixed at Bottom) -->
    <div class="shrink-0 p-4 border-t border-slate-700/50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-2 text-gray-400 hover:text-white px-3 py-2 rounded-lg hover:bg-slate-800 transition text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Log out</span>
            </button>
        </form>
    </div>
</aside>