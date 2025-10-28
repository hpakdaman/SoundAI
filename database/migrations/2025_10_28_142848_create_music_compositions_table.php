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
        Schema::create('music_compositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();

            // Genre (predefined or custom)
            $table->foreignId('genre_id')->nullable()->constrained('music_genres')->onDelete('set null');
            $table->string('custom_genre', 100)->nullable();

            // Custom inputs
            $table->string('custom_vibe')->nullable();
            $table->json('custom_instruments')->nullable();

            // Generation parameters
            $table->integer('tempo')->nullable();
            $table->integer('duration')->nullable();
            $table->string('key_signature', 20)->nullable();
            $table->string('time_signature', 10)->nullable();
            $table->text('style_keywords')->nullable();

            // AI generation
            $table->text('full_prompt');
            $table->string('prompt_pattern_used', 50)->default('standard');
            $table->json('generation_parameters')->nullable();

            // File & processing
            $table->string('audio_file_path', 500)->nullable();
            $table->json('waveform_data')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('file_format', 10)->nullable();

            // Status
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->integer('processing_time')->nullable();
            $table->decimal('cost_estimate', 8, 4)->nullable();

            // Privacy & engagement
            $table->enum('privacy', ['public', 'private', 'unlisted'])->default('public');
            $table->boolean('featured')->default(false);
            $table->bigInteger('play_count')->default(0);
            $table->bigInteger('download_count')->default(0);
            $table->bigInteger('like_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('title');
            $table->index('custom_genre');
            $table->index('status');
            $table->index('privacy');
            $table->index('featured');
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_compositions');
    }
};
