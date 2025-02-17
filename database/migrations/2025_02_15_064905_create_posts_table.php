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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('thumnail_url', 255);
            $table->text('description_short');
            $table->text('content');
            $table->unsignedBigInteger('post_categori_id');
            $table->unsignedBigInteger('customer_ad_id');
            $table->timestamps();

            $table->foreign('post_categori_id')->references('id')->on('post_categories')->onDelete('cascade');
            $table->foreign('customer_ad_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
