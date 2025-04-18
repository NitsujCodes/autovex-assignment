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
        Schema::create('carts', function (Blueprint $table) {
            // Structure
            $table->id();
            $table->foreignId('user_id');
            $table->integer('total_value');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('session_id');
            $table->index('total_value');

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
