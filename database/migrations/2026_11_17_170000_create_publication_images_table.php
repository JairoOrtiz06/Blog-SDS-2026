<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publication_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publication_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('original_filename');
            $table->unsignedTinyInteger('position')->default(0);
            $table->timestamps();

            $table->index(['publication_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_images');
    }
};
