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
        Schema::create('music_generation_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('composition_id')->nullable()->constrained('music_compositions')->onDelete('set null');
            $table->text('full_prompt');
            $table->string('prompt_pattern_used', 50);
            $table->json('generation_parameters')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed']);
            $table->text('error_message')->nullable();
            $table->json('api_response')->nullable();
            $table->integer('processing_time')->nullable();
            $table->decimal('cost', 8, 4)->nullable();
            $table->string('vertex_ai_job_id')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_generation_history');
    }
};
