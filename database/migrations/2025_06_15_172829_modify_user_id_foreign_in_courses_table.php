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
        Schema::table('courses', function (Blueprint $table) {
            // Elimina la clave foránea existente
            $table->dropForeign(['user_id']);

            // Agrega de nuevo con eliminación en cascada
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Revertir el cambio
            $table->dropForeign(['user_id']);

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('restrict'); // o sin onDelete, que es el default
        });
    }
};
