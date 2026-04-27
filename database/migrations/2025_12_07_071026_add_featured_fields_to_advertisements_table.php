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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('type');
            $table->dateTime('featured_until')->nullable()->after('is_featured');
            $table->enum('feature_type', ['none', 'basic', 'premium'])->default('none')->after('featured_until');

            // Index for featured ads queries
            $table->index(['is_featured', 'featured_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropIndex(['is_featured', 'featured_until']);
            $table->dropColumn(['is_featured', 'featured_until', 'feature_type']);
        });
    }
};
