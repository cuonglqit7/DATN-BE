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
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('recipient_name', 50);
            $table->string('recipient_phone', 10);
            $table->string('shipping_address', 500);
            $table->timestamp('order_date')->useCurrent();
            $table->decimal('total_price', 10, 2)->notNull();
            $table->enum('payment_method', ['Bank_transfer', 'Momo', 'cod'])->default('COD');
            $table->enum('payment_status', ['Pending', 'Completed', 'Failed', 'Refunded'])->default('Pending');
            $table->enum('status', ['Pending', 'Completed', 'Cancelled'])->default('Pending');
            $table->string('user_note', 200)->nullable();
            $table->string('admin_note', 200)->nullable();
            $table->string('ip_address', 45);
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
