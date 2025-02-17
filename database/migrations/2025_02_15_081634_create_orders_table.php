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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 8)->unique();
            $table->string('recipient_name', 255);
            $table->string('recipient_phone', 10);
            $table->string('shipping_address', 500);
            $table->string('note_user', 200)->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'credit_card', 'momo']);
            $table->dateTime('ordered_at');
            $table->dateTime('completed_at');
            $table->string('note_admin', 200)->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
