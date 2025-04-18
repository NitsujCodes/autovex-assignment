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
        Schema::create('storage_files', function (Blueprint $table) {
            // Structure
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('relative_path');
            $table->integer('size');
            $table->string('extension');
            $table->string('mime_type');
            $table->string('disk');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique(['uuid', 'disk']);
            $table->index('size');
            $table->index('extension');
            $table->index('mime_type');
            $table->index('disk');
            $table->index('relative_path');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_files');
    }
};
