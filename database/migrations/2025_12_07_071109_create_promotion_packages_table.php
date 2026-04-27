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
        Schema::create('promotion_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basic, Premium, VIP
            $table->integer('duration_days'); // 7, 14, 30
            $table->decimal('price_points', 10, 2); // Points required
            $table->json('benefits')->nullable(); // JSON array of benefits
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index for active packages
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_packages');
    }
};
