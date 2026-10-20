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
        Schema::table('profiles', function (Blueprint $table): void {
            $table->json('translations')->nullable()->after('resume_path');
        });

        Schema::table('experiences', function (Blueprint $table): void {
            $table->json('translations')->nullable()->after('impact');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->json('translations')->nullable()->after('image_height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table): void {
            $table->dropColumn('translations');
        });

        Schema::table('experiences', function (Blueprint $table): void {
            $table->dropColumn('translations');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn('translations');
        });
    }
};
