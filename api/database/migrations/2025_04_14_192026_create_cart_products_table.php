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
        Schema::create('cart_product', function (Blueprint $table) {
            // Structure
            $table->id();
            $table->foreignId('cart_id');
            $table->foreignId('product_id');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('quantity');
            $table->index('cart_id');
            $table->index('product_id');

            // Foreign Keys
            $table->foreign('cart_id')->references('id')->on('carts')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product');
    }
};
