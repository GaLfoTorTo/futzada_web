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
        Schema::create('peladas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo',['Completa','Rapida'])->default('Completa');
            $table->string('nome');
            $table->text('bio')->nullable();
            $table->enum('visibilidade',['Publica','Privada'])->default('Publica');
            $table->text('foto')->nullable();
            $table->boolean('local_fixo')->default(false);
            $table->string('endereco')->nullable();
            $table->boolean('dia_hora_fixo')->default(false);
            $table->string('dia_semana')->nullable();
            $table->date('data')->nullable();
            $table->string('hora')->nullable();
            $table->enum('tipo_campo',['Gramado','Society','Quadra'])->default('Quadra');
            $table->integer('qtd_jogadores')->nullable();
            $table->boolean('levar_bola')->default(false);
            $table->boolean('arbitro')->default(false);
            $table->boolean('status_colaboradores')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peladas');
    }
};
