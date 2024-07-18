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
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelada_id');
            $table->foreign('pelada_id')->references('id')->on('peladas')->onDelete('cascade');
            $table->string('equipe')->nullable();
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
        Schema::dropIfExists('equipes');
    }
};
