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
        Schema::create('jogadors', function (Blueprint $table) {
            $arquetipos = [
                "Goleiro Clássico","Goleador","Capitão","Artilheiro","Driblador","Carrasco das Bolas Paradas","Mestre da Defesa","Talento em Ascensão","Estrategista do Meio-Campo","Atacante Veloz","Firme na Marcação","Líder Nato","Motor do Time","Veterano","Versátil","Raçudo","Incansável","Gênio da Assistência","Muralha","Destruidor de Jogadas","Garçom","Estrategista Tático","Finalizador","Gênio","Lenda","Caçador","Guerreiro","Mágico","Bruxo","Lutador","Especialista em Cruzamentos","Maestro","Camisa 10 Clássico","Sem Freio","Acelerador","Dono da Area","Expert na Recuperação","Sem Pressão","Articulador","Estrategista","Imbatível","Mestre da Comunicação","Especialista em Desarmes","Controlador do Ritmo","Mito da Torcida","Lançador","Determinado","Jogador de Classe","Joga de terno","Velocista","Inteligente","Ídolo","Marcador","Vai e Volta","Trator","Retranqueiro","Experiente","Protetor do Gol","Dono do Campo","Gelado",
            ];
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->enum('arquetipo',$arquetipos);
            $table->enum('melhor_pe',['Direita','Esquerda'])->default('Direita');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogadors');
    }
};
