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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('role', ['Player','Manager','Refereer'])->default('Player');
            $table->decimal('points', 8, 2)->default(0.0);
            $table->decimal('avarage', 8, 2)->default(0.0);
            $table->decimal('valuation', 10, 2)->default(0.0);
            $table->decimal('price', 10, 2)->default(0.0);
            $table->integer('games')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
