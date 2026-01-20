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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('nama_media');
            $table->string('file_path'); // Path ke file video/gambar
            $table->enum('tipe_media', ['video', 'gambar'])->default('gambar');
            $table->integer('durasi')->nullable(); // Durasi dalam detik (untuk video)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
