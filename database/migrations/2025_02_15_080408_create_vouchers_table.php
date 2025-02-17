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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percent', 'fixed']);
            $table->decimal('discount_value', 10, 2)->check('discount_value' >= 0);
            $table->text('list_product_code')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->check('end_date' > 'start_date');
            $table->decimal('minimum_total', 10, 2)->default(0)->check('minimum_total' >= 0);
            $table->unsignedBigInteger('usage_limit')->default(0)->check('usage_limit' >= 0);
            $table->unsignedBigInteger('per_user_limit')->default(1)->check('per_user_limit' >= 0);
            $table->boolean('new_customer_only')->default(false);
            $table->enum('status', ['active', 'inactive', 'expired'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
