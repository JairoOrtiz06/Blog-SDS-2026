<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidence_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evidence_id')->constrained('evidences')->cascadeOnDelete();
            $table->string('path');
            $table->string('original_filename');
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidence_attachments');
    }
};
