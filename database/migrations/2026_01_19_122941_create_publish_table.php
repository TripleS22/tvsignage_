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
        Schema::create('publish', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')->constrained('outlet')->onDelete('cascade');
            $table->foreignId('gabungan_id')->constrained('gabungan')->onDelete('cascade');
            $table->boolean('is_online')->default(false); // Status online device
            $table->timestamp('last_ping')->nullable(); // Waktu terakhir device online
            $table->timestamp('published_at')->nullable(); // Waktu publish
            $table->enum('status', ['draft', 'published', 'stopped'])->default('draft');
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publish');
    }
};
