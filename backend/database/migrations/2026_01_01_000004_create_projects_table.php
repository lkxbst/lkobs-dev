<?php

declare(strict_types=1);

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
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('year');
            $table->text('description');
            $table->json('tags');
            $table->string('live_url')->nullable();
            $table->string('repo_url')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->unsignedSmallInteger('image_width')->nullable();
            $table->unsignedSmallInteger('image_height')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
