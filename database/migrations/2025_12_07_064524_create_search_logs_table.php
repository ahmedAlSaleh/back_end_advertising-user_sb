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
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('city')->nullable();
            $table->decimal('price_min', 10, 2)->nullable();
            $table->decimal('price_max', 10, 2)->nullable();
            $table->decimal('rating_min', 3, 2)->nullable();
            $table->string('sort_by')->nullable();
            $table->string('sort_order')->nullable();
            $table->integer('results_count')->default(0);
            $table->string('user_ip')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('keyword');
            $table->index('city');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_logs');
    }
};
