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
        Schema::create('profiles', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('handle');
            $table->string('city');
            $table->text('headline');
            $table->string('headline_highlight');
            $table->boolean('is_available')->default(true);
            $table->string('availability_label');
            $table->text('about_primary');
            $table->text('about_secondary');
            $table->json('tools');
            $table->string('email');
            $table->string('resume_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
