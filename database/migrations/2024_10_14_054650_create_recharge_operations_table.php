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
        Schema::create('recharge_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trader_id')->constrained('traders')->onDelete('cascade');
            $table->string('code');
            $table->enum('type',['form_code','from_admin']);
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharge_operations');
    }
};
