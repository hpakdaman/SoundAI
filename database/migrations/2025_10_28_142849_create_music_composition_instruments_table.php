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
        Schema::create('music_composition_instruments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('composition_id')->constrained('music_compositions')->onDelete('cascade');
            $table->foreignId('instrument_id')->constrained('music_instruments')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['composition_id', 'instrument_id']);
            $table->index('composition_id');
            $table->index('instrument_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_composition_instruments');
    }
};
