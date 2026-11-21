<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->timestamps();
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->timestamps();
            $table->primary(['team_id', 'user_id']);
            $table->unique('user_id');
        });

        Schema::table('evidences', function (Blueprint $table) {
            $table->foreignId('team_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();
            $table->foreignId('participant_id')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('evidences', function (Blueprint $table) {
            $table->dropConstrainedForeignId('participant_id');
            $table->dropConstrainedForeignId('team_id');
        });

        Schema::dropIfExists('team_user');
        Schema::dropIfExists('teams');
    }
};
