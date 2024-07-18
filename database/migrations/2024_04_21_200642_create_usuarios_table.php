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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nome');
            $table->string('sobrenome')->nullabel();
            $table->string('user_name')->nullabel();
            $table->string('email')->unique();
            $table->string('password')->nullabel();
            $table->string('telefone', 13)->nullabel();
            $table->date('data_nascimento')->nullabel();
            $table->enum('visibilidade',['Publico','Privado'])->default('Publico');
            $table->text('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
