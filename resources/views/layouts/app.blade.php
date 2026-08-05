<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fixly') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">
    <div class="min-h-screen flex">
        
        <!-- PANGGIL SIDEBAR DI SINI -->
        @include('layouts.sidebar')

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar Nav Header -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-8 border-b border-gray-100">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-xs text-gray-500">Selamat datang di Sistem Manajemen Servis dan Perbaikan Perangkat IT</p>
                </div>

                <!-- Bagian User Profile Topbar -->
                <div class="flex items-center space-x-2 text-gray-800 font-medium text-sm">
                    <!-- Icon People / User -->
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>

                    <!-- Hanya Teks Role/Nama User Berwarna Hitam -->
                    @php
                        $roleUser = Auth::user()->role ?? null;
                        if (is_object($roleUser) || is_array($roleUser)) {
                            $roleName = $roleUser['nama'] ?? $roleUser->nama ?? Auth::user()->name;
                        } else {
                            $roleName = $roleUser ?? Auth::user()->name;
                        }
                    @endphp

                    <span class="text-gray-900 capitalize">{{ $roleName }}</span>
                </div>
            </header>

            <!-- Halaman Konten Dinamis -->
            <main class="flex-1 overflow-y-auto p-8">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html> 