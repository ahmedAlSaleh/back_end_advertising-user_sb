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
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->index('phone');
            $table->index('email');
        });

        // Traders table indexes
        Schema::table('traders', function (Blueprint $table) {
            $table->index('owner_contact_number');
            $table->index('city');
        });

        // Advertisements table indexes
        Schema::table('advertisements', function (Blueprint $table) {
            $table->index('trader_id');
            $table->index('type');
        });

        // Favorites table indexes
        Schema::table('favorites', function (Blueprint $table) {
            $table->index(['user_id', 'favorite_type', 'favorite_id'], 'favorites_composite_index');
        });

        // Recharge_codes table indexes
        Schema::table('recharge_codes', function (Blueprint $table) {
            $table->unique('code');
            $table->index('is_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['phone']);
            $table->dropIndex(['email']);
        });

        // Drop Traders table indexes
        Schema::table('traders', function (Blueprint $table) {
            $table->dropIndex(['owner_contact_number']);
            $table->dropIndex(['city']);
        });

        // Drop Advertisements table indexes
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropIndex(['trader_id']);
            $table->dropIndex(['type']);
        });

        // Drop Favorites table indexes
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropIndex('favorites_composite_index');
        });

        // Drop Recharge_codes table indexes
        Schema::table('recharge_codes', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropIndex(['is_used']);
        });
    }
};
