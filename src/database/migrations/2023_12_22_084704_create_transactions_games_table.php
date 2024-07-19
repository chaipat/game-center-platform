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
        Schema::create('transactions_games', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->integer('user_id')->default(0);
            $table->integer('game_id')->default(0);
            $table->integer('round_id')->default(0);
            $table->decimal('bet', 10, 2)->default(0);
            $table->decimal('win', 10, 2)->default(0);
            $table->decimal('losses', 10, 2)->default(0);
            $table->decimal('profit', 10, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_games');
    }
};
