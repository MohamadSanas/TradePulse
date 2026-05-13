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
        if (! Schema::hasTable('effective_buy_prices')) {
            return;
        }

        Schema::table('effective_buy_prices', function (Blueprint $table) {
            if (! Schema::hasColumn('effective_buy_prices', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('effective_buy_prices') || ! Schema::hasColumn('effective_buy_prices', 'user_id')) {
            return;
        }

        Schema::table('effective_buy_prices', function (Blueprint $table) {
            $table->dropForeign('effective_buy_prices_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
};
