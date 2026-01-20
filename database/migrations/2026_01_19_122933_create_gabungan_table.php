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
        Schema::create('gabungan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gabungan');
            $table->text('deskripsi')->nullable();
            $table->integer('jeda_detik')->default(5); // Jeda per detik antar media
            $table->timestamps();
        });

        // Pivot table untuk relasi many-to-many antara gabungan dan media
        Schema::create('gabungan_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gabungan_id')->constrained('gabungan')->onDelete('cascade');
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade');
            $table->integer('urutan')->default(0); // Urutan tampil media dalam gabungan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gabungan_media');
        Schema::dropIfExists('gabungan');
    }
};
