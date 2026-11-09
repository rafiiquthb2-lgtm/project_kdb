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
        Schema::create('transaction_detail', function (Blueprint $table) {
            $table->string('transaction_id')->primary();
            $table->date('transaction_date');
            $table->string('customer_id');
            $table->string('payment_method');
            $table->decimal('before_tax', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('after_tax', 15, 2);
            $table->decimal('shipping_cost', 15, 2);
            $table->decimal('transaction_discount', 15, 2);
            $table->decimal('total_paid', 15, 2);

            $table->foreign('customer_id')
                  ->references('customer_id')
                  ->on('customer_detail')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_detail');
    }
};
