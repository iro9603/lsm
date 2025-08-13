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
        Schema::create('instructor_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con usuarios
            $table->string('video_path')->nullable();
            $table->string('video_original_name')->nullable();
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->text('about_me')->nullable();
            $table->string('subject')->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('is_published')->default(1);
            $table->boolean('is_preview')->default(0);
            $table->boolean('is_processed')->default(0);
            $table->integer('platform');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_infos');
    }
};
