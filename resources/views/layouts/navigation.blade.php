<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left Side Nav (Logo + Links) -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8 h-full">
                    @auth
                        @php
                            $roleName = strtolower(Auth::user()->role->name ?? Auth::user()->role->nama_role ?? '');
                            $roleId = Auth::user()->role_id ?? null;
                        @endphp

                        {{-- 1. KHUSUS TEKNISI --}}
                        @if($roleName == 'teknisi' || $roleId == 2) 
                            <x-nav-link :href="route('teknisi.dashboard')" :active="request()->routeIs('teknisi.dashboard')">
                                {{ __('Dashboard Teknisi') }}
                            </x-nav-link>

                            <x-nav-link :href="route('teknisi.tugas')" :active="request()->routeIs('teknisi.tugas')">
                                {{ __('Tugas Saya') }}
                            </x-nav-link>

                        {{-- 2. KHUSUS PELAPOR --}}
                        @elseif($roleName == 'pelapor' || $roleId == 3)
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                                {{ __('Laporan Kerusakan') }}
                            </x-nav-link>

                        {{-- 3. KHUSUS ADMIN / LAINNYA --}}
                        @else
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('ruangan.index')" :active="request()->routeIs('ruangan.*')">
                                {{ __('Data Ruangan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('jenis-kerusakan.index')" :active="request()->routeIs('jenis-kerusakan.*')">
                                {{ __('Jenis Kerusakan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('perangkat.index')" :active="request()->routeIs('perangkat.*')">
                                {{ __('Data Perangkat') }}
                            </x-nav-link>
                            <x-nav-link :href="route('role.index')" :active="request()->routeIs('role.*')">
                                {{ __('Data Role') }}
                            </x-nav-link>
                            <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.*')">
                                {{ __('Data User') }}
                            </x-nav-link>
                            <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                                {{ __('Laporan Kerusakan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('penugasan.index')" :active="request()->routeIs('penugasan.*')">
                                {{ __('Penugasan Teknisi') }}
                            </x-nav-link>
                            <x-nav-link :href="route('tindakan-perbaikan.index')" :active="request()->routeIs('tindakan-perbaikan.*')">
                                {{ __('Tindakan Perbaikan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('riwayat-status.index')" :active="request()->routeIs('riwayat-status.*')">
                                {{ __('Riwayat Status') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side Nav (Settings Dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if($roleName == 'teknisi' || $roleId == 2)
                    <x-responsive-nav-link :href="route('teknisi.dashboard')" :active="request()->routeIs('teknisi.dashboard')">
                        {{ __('Dashboard Teknisi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('teknisi.tugas')" :active="request()->routeIs('teknisi.tugas')">
                        {{ __('Tugas Saya') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>