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
        Schema::create('customer_detail', function (Blueprint $table) {
            $table->string('customer_id')->primary();
            $table->date('registration_date');
            $table->text('customer_name'); // Stores AES-256 encrypted ciphertext
            $table->string('customer_type');
            $table->text('dob'); // Stores AES-256 encrypted ciphertext
            $table->string('province');
            $table->string('registration_channel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_detail');
    }
};
