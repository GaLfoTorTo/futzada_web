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
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->unsignedBigInteger('pelada_id');
            $table->foreign('pelada_id')->references('id')->on('peladas')->onDelete('cascade');
            $table->integer('duracao')->nullable();
            $table->enum('tempos',['1','2'])->defalut('1');
            $table->integer('limite_gols')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
