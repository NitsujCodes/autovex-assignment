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
        Schema::create('documentables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_file_id');
            $table->morphs('documentable');
            $table->timestamps();

            // Indexes
            $table->unique('storage_file_id');
            $table->unique(['imageable_id', 'imageable_type']);

            // Foreign Keys
            $table->foreign('storage_file_id')->references('id')->on('storage_files')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentables');
    }
};
