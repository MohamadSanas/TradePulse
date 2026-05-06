<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
        $table->id();
        $table->enum('type', ['buy','sell']);
        $table->decimal('amount_usdt', 10, 2);
        $table->decimal('bank_fee', 10, 2);
        $table->decimal('total_lkr', 12, 2);
        $table->decimal('fee', 10, 2)->nullable();
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
