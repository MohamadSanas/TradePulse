<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('effective_buy_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('Average_Buy_Price', 12, 2);
            $table->decimal('remaining_usdt', 12, 2);
            $table->decimal('remaining_lkr', 12, 2);
            $table->decimal('Breakeven_Price', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('effective_buy_prices');
    }
};