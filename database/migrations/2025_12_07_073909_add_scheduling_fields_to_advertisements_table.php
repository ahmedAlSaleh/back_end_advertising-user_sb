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
            $table->dateTime('scheduled_at')->nullable()->after('type');
            $table->dateTime('expires_at')->nullable()->after('scheduled_at');
            $table->enum('status', ['draft', 'scheduled', 'active', 'expired', 'paused'])->default('active')->after('expires_at');

            // Indexes for performance
            $table->index('scheduled_at');
            $table->index('expires_at');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropIndex(['scheduled_at']);
            $table->dropIndex(['expires_at']);
            $table->dropIndex(['status']);
            $table->dropColumn(['scheduled_at', 'expires_at', 'status']);
        });
    }
};
