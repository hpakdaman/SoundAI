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
        Schema::create('music_composition_vibes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('composition_id')->constrained('music_compositions')->onDelete('cascade');
            $table->foreignId('vibe_id')->constrained('music_vibes')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['composition_id', 'vibe_id'], 'composition_vibe_unique');
            $table->index('composition_id');
            $table->index('vibe_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_composition_vibes');
    }
};
