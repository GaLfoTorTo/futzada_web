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
        Schema::create('pontuacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelada_id');
            $table->foreign('pelada_id')->references('id')->on('peladas')->onDelete('cascade');
            $table->unsignedBigInteger('participante_id');
            $table->foreign('participante_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->enum('modalidade', ['Jogador','Técnico','Arbitro'])->default('Jogador');
            $table->decimal('pontos')->default(0.0);
            $table->decimal('media')->nullable();
            $table->decimal('valorizacao')->nullable();
            $table->decimal('preco')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pontuacaos');
    }
};
