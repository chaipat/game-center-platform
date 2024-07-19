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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('contry_code', 4);
            $table->string('contract', 15);
            $table->string('channel', 15);
            $table->integer('length_otp');
            $table->integer('length_ref_code');
            $table->string('code', 10);
            $table->string('ref_cde', 10);
            $table->integer('verify_count');
            $table->string('status', 15);
            $table->timestamps('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
