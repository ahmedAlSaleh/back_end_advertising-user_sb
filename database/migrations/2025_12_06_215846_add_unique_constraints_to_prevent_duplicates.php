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
        // Add unique constraint to blocks table
        Schema::table('blocks', function (Blueprint $table) {
            $table->unique(['user_id', 'blocked_id', 'blocked_type'], 'unique_user_block');
        });

        // Add unique constraint to rates table
        Schema::table('rates', function (Blueprint $table) {
            $table->unique(['user_id', 'rated_id', 'rated_type'], 'unique_user_rate');
        });

        // Add unique constraints to likes table
        Schema::table('likes', function (Blueprint $table) {
            // For users liking posts
            $table->unique(['post_id', 'user_id'], 'unique_user_like');
            // For traders liking posts
            $table->unique(['post_id', 'trader_id'], 'unique_trader_like');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop unique constraint from blocks table
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropUnique('unique_user_block');
        });

        // Drop unique constraint from rates table
        Schema::table('rates', function (Blueprint $table) {
            $table->dropUnique('unique_user_rate');
        });

        // Drop unique constraints from likes table
        Schema::table('likes', function (Blueprint $table) {
            $table->dropUnique('unique_user_like');
            $table->dropUnique('unique_trader_like');
        });
    }
};
