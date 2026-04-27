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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_id'); // The user/trader who reported
            $table->string('reporter_type'); // user, trader
            $table->unsignedBigInteger('reportable_id'); // The item being reported
            $table->string('reportable_type'); // advertisement, store, trader, post
            $table->enum('reason', ['spam', 'fraud', 'inappropriate', 'misleading', 'offensive', 'other']);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->dateTime('resolved_at')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable(); // Admin who resolved
            $table->timestamps();

            // Indexes for performance
            $table->index(['reporter_type', 'reporter_id']);
            $table->index(['reportable_type', 'reportable_id']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
