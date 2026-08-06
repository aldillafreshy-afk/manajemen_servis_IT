<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\JenisKerusakanController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanKerusakanController;
use App\Http\Controllers\PenugasanTeknisiController;
use App\Http\Controllers\TindakanPerbaikanController;
use App\Http\Controllers\RiwayatStatusController;
use App\Http\Controllers\DashboardController; // ← TAMBAHKAN INI

Route::middleware(['auth'])->group(function () {
    Route::resource('ruangan', RuanganController::class);
    Route::resource('jenis-kerusakan', JenisKerusakanController::class);
    Route::resource('perangkat', PerangkatController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('laporan', LaporanKerusakanController::class);
    Route::resource('penugasan', PenugasanTeknisiController::class);
    Route::resource('tindakan-perbaikan', TindakanPerbaikanController::class);
    Route::resource('riwayat-status', RiwayatStatusController::class);
});

// Route::middleware(['auth'])->group(function () {
//     // Route tugas teknisi
//     Route::get('/tugas-saya', [PenugasanTeknisiController::class, 'tugasSaya'])->name('teknisi.tugas');
//     Route::get('/tugas-saya/{id}', [PenugasanTeknisiController::class, 'show'])->name('teknisi.tugas.show');
//     Route::get('/teknisi/dashboard', [PenugasanTeknisiController::class, 'dashboardTeknisi'])->name('teknisi.dashboard');
// });

Route::middleware(['auth'])->group(function () {
    // Route tugas teknisis

    Route::get('/teknisi/dashboard', [PenugasanTeknisiController::class, 'dashboardTeknisi'])
        ->name('teknisi.dashboard');
    
    Route::get('/tugas-saya', [PenugasanTeknisiController::class, 'tugasSaya'])
        ->name('teknisi.tugas');
    
    Route::get('/tugas-saya/{id}', [PenugasanTeknisiController::class, 'show'])
        ->name('teknisi.tugas.show');
});

Route::get('/', function () {
    return redirect()->route('login');
});

// ===== PERBAIKI INI =====
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';