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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('transaction_id');
            $table->string('customer_id');
            $table->date('order_date');
            $table->string('channel_type');
            $table->string('sku_id');
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->decimal('before_discount', 15, 2);
            $table->decimal('discount_item', 15, 2);
            $table->decimal('after_discount', 15, 2);
            $table->boolean('is_gross')->default(false);
            $table->boolean('is_valid')->default(false);
            $table->boolean('is_net')->default(false);

            $table->foreign('transaction_id')
                  ->references('transaction_id')
                  ->on('transaction_detail')
                  ->onDelete('cascade');

            $table->foreign('customer_id')
                  ->references('customer_id')
                  ->on('customer_detail')
                  ->onDelete('cascade');

            $table->foreign('sku_id')
                  ->references('sku_id')
                  ->on('product_detail')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
