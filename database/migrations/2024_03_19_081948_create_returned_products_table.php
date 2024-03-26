<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('returned_products', function (Blueprint $table) {
            $table->id();
            $table->morphs('returnable');
            $table->integer('payable')->nullable();
            $table->integer('receivable')->nullable();
            $table->integer('total_product_amount')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('total_bill_amount')->nullable();
            $table->string('bill_no');
            $table->integer('stock')->nullable();
            $table->foreignId('bill_under')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->date('bill_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returned_products');
    }
};
