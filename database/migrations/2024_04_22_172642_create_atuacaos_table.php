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
        Schema::create('atuacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partida_id');
            $table->foreign('partida_id')->references('id')->on('peladas')->onDelete('cascade');
            $table->unsignedBigInteger('jogador_id');
            $table->foreign('jogador_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->unsignedBigInteger('equipe_id');
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
            $table->unsignedBigInteger('acao_id');
            $table->foreign('acao_id')->references('id')->on('acaos')->onDelete('cascade');
            $table->string ('tempo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atuacaos');
    }
};
