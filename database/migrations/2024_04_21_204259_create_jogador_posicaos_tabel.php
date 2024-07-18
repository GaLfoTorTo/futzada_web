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
        Schema::create('jogador_posicaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->unsignedBigInteger('posicao_id');
            $table->foreign('posicao_id')->references('id')->on('posicaos')->onDelete('cascade');
            $table->boolean('principal')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogador_posicaos');
    }
};
