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
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelada_id');
            $table->foreign('pelada_id')->references('id')->on('peladas')->onDelete('cascade');
            $table->unsignedBigInteger('equipe_1_id');
            $table->foreign('equipe_1_id')->references('id')->on('equipes')->onDelete('cascade');
            $table->unsignedBigInteger('equipes_2_id');
            $table->foreign('equipes_2_id')->references('id')->on('equipes')->onDelete('cascade');
            $table->integer('equipes_1')->default(0)->nullable();
            $table->integer('equipes_2')->default(0)->nullable();
            $table->string('tempo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
