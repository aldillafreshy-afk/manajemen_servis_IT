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
        Schema::create('tindakan_perbaikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_id')->constrained('penugasan_teknisis')->onDelete('cascade');
            $table->text('deskripsi_tindakan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status_hasil', ['proses', 'berhasil', 'gagal_diperbaiki', 'pending_sparepart'])->default('proses');
            $table->decimal('biaya', 12, 2)->default(0);
            $table->text('catatan_teknisi')->nullable();
            $table->timestamps();
        });
    }
        /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindakan_perbaikans');
    }
};
