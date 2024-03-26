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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->morphs('billable');
            $table->float('payable')->nullable();
            $table->float('receivable')->nullable();
            $table->float('total_product_amount')->nullable();
            $table->float('rate')->nullable();
            $table->float('total_bill_amount')->nullable();
            $table->string('bill_no');
            $table->float('stock')->nullable();
            $table->float('discount_percentage')->nullable();
            $table->float('discount_amount')->nullable();
            $table->boolean('vat')->default(0);
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
        Schema::dropIfExists('bills');
    }
};
