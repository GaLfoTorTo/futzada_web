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
        Schema::create('escalacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tecnico_id');
            $table->foreign('tecnico_id')->references('id')->on('tecnicos')->onDelete('cascade');
            $table->unsignedBigInteger('partida_id');
            $table->foreign('partida_id')->references('id')->on('partidas')->onDelete('cascade');
            $table->string('formacao');
            $table->unsignedBigInteger('capitao_id')->nullable();
            $table->unsignedBigInteger('j1_id')->nullable();
            $table->unsignedBigInteger('j2_id')->nullable();
            $table->unsignedBigInteger('j3_id')->nullable();
            $table->unsignedBigInteger('j4_id')->nullable();
            $table->unsignedBigInteger('j5_id')->nullable();
            $table->unsignedBigInteger('j6_id')->nullable();
            $table->unsignedBigInteger('j7_id')->nullable();
            $table->unsignedBigInteger('j8_id')->nullable();
            $table->unsignedBigInteger('j9_id')->nullable();
            $table->unsignedBigInteger('j10_id')->nullable();
            $table->unsignedBigInteger('j11_id')->nullable();
            $table->unsignedBigInteger('r1_id')->nullable();
            $table->unsignedBigInteger('r2_id')->nullable();
            $table->unsignedBigInteger('r3_id')->nullable();
            $table->unsignedBigInteger('r4_id')->nullable();
            $table->unsignedBigInteger('r5_id')->nullable();
            $table->foreign('capitao_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j1_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j2_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j3_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j4_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j5_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j6_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j7_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j8_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j9_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j10_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('j11_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('r1_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('r2_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('r3_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('r4_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->foreign('r5_id')->references('id')->on('participantes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escalacaos');
    }
};
