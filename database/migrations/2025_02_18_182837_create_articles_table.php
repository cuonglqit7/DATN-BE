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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('slug', 100)->unique();
            $table->string('thumbnail_url', 255);
            $table->text('short_desciption');
            $table->text('content');
            $table->foreignId('product_id')->nullable()->constrained('products', 'id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreignId('article_category_id')->constrained('article_categories', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
