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
        Schema::create('outlet', function (Blueprint $table) {
            $table->id();
            $table->string('kode_outlet')->unique();
            $table->string('nama_outlet');
            $table->foreignId('gabungan_id')->nullable()->constrained('gabungan')->onDelete('set null');
            $table->enum('status', ['aktif', 'tidak_aktif', 'dijadwalkan'])->default('tidak_aktif');
            $table->timestamp('jadwal_mulai')->nullable(); // Untuk status dijadwalkan
            $table->timestamp('jadwal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet');
    }
};
