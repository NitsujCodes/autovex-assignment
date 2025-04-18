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
        Schema::create('imageables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_file_id');
            $table->morphs('imageable');
            $table->integer('order')->default(0);
            $table->timestamps();

            // Indexes
            $table->unique('storage_file_id');
            $table->unique(['storage_file_id', 'imageable_id', 'imageable_type']);
            $table->index('order');

            // Foreign Keys
            $table->foreign('storage_file_id')->references('id')->on('storage_files')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imageables');
    }
};
