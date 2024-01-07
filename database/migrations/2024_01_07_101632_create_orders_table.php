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
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 20, 2);
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('status', ['new', 'process', 'delivered', 'cancel'])->default('new');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('CASCADE');
            $table->foreignId('coupon_id')->nullable()->references('id')->on('coupons')->onDelete('CASCADE');
            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->double('price');
            $table->foreignId('order_id')->references('id')->on('orders')->onDelete('CASCADE');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('CASCADE');
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
