<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penugasan_teknisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan_kerusakans')->onDelete('cascade');
            $table->foreignId('teknisi_id')->constrained('users')->onDelete('cascade'); // Diambil dari user yang rolenya teknisi
            $table->date('tanggal_penugasan');
            $table->enum('status_penugasan', ['ditugaskan', 'proses', 'selesai', 'dibatalkan'])->default('ditugaskan');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan_teknisis');
    }
};
