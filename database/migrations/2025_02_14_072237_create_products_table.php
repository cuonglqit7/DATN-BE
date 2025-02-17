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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code', 50)->unique();
            $table->string('name', 255);
            $table->string('thumbnail_url')->nullable();
            $table->string('slug', 255)->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('position')->default(0)->check('posistion' > 0);
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('number_purchases')->default(0);
            $table->string('made_in', 100)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
