<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // references the post
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // references the user who liked/disliked
            $table->boolean('like'); // true for like, false for dislike
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }

};
