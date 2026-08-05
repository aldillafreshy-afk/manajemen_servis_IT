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
        Schema::create('perangkats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perangkat', 30)->unique();
            $table->string('nama_perangkat', 255);
            $table->string('jenis_perangkat', 100);
            $table->string('merk', 100);
            
            // Relasi Foreign Key ke tabel ruangans
            $table->foreignId('ruangan_id')->constrained('ruangans')->onDelete('cascade');
            
            $table->date('tahun_pembelian');
            $table->enum('status', ['Aktif', 'rusak', 'servis'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkats');
    }
};
