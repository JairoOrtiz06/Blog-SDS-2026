<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $now = now();
        foreach ([
            'Ponencias',
            'Talleres',
            'Bingo',
            'Feria de proyectos',
            'Comelona de pizza',
            'Torneo de fútbol sala',
            'Parrillada',
        ] as $name) {
            DB::table('categories')->insert([
                'name' => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        Schema::table('publications', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();
        });

        DB::table('publications')
            ->select(['id', 'category'])
            ->whereNotNull('category')
            ->orderBy('id')
            ->chunkById(100, function ($publications) use ($now): void {
                foreach ($publications as $publication) {
                    $name = trim($publication->category);
                    if ($name === '') {
                        continue;
                    }

                    $categoryId = DB::table('categories')
                        ->where('name', $name)
                        ->value('id');

                    if (! $categoryId) {
                        $categoryId = DB::table('categories')->insertGetId([
                            'name' => $name,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }

                    DB::table('publications')
                        ->where('id', $publication->id)
                        ->update(['category_id' => $categoryId]);
                }
            });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->string('category')->nullable()->index();
        });

        DB::table('publications')
            ->select(['id', 'category_id'])
            ->whereNotNull('category_id')
            ->orderBy('id')
            ->chunkById(100, function ($publications): void {
                foreach ($publications as $publication) {
                    $name = DB::table('categories')
                        ->where('id', $publication->category_id)
                        ->value('name');

                    DB::table('publications')
                        ->where('id', $publication->id)
                        ->update(['category' => $name]);
                }
            });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::dropIfExists('categories');
    }
};
