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
        Schema::table('available_slots', function (Blueprint $table) {
            $table->boolean('is_temporarily_blocked')->default(false);
            $table->timestamp('temporarily_blocked_until')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_slots', function (Blueprint $table) {
            //
        });
    }
};
