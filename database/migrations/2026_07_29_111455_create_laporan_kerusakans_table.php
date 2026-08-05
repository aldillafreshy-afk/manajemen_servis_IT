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
        Schema::create('laporan_kerusakans', function (Blueprint $table) {
            $table->id();
            
            // Relasi Foreign Keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('perangkat_id')->constrained('perangkats')->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained('ruangans')->onDelete('cascade');
            $table->foreignId('jenis_kerusakan_id')->constrained('jenis_kerusakans')->onDelete('cascade');
            
            $table->text('deskripsi_kerusakan');
            $table->string('foto', 255)->nullable();
            $table->enum('tingkat_urgensi', ['rendah', 'sedang', 'tinggi'])->default('rendah');
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->timestamp('tanggal_lapor')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakans');
    }
};
