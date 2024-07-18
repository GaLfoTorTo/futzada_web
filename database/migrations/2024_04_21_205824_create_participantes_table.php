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
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelada_id');
            $table->foreign('pelada_id')->references('id')->on('peladas')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->boolean('jogador')->default(true);
            $table->boolean('tecnico')->default(false);
            $table->boolean('arbitro')->default(false);
            $table->boolean('organizador')->default(false);
            $table->boolean('colaborador')->default(false);
            $table->text('permissoes')->default(json_encode(['Adicionar','Editar','Remover']));
            $table->enum('status', ['Disponível','Duvida','Machucado','Fora'])->default('Disponível');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
