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
        Schema::create('product_detail', function (Blueprint $table) {
            $table->string('sku_id')->primary();
            $table->string('category');
            $table->string('brand');
            $table->string('product');
            $table->string('variant')->nullable();
            $table->string('sku_name');
            $table->decimal('price', 15, 2);
            $table->decimal('cogs', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_detail');
    }
};
