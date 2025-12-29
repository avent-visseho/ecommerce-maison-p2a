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
        // Ajouter les colonnes de traduction pour blog_posts
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('excerpt_translations')->nullable()->after('excerpt');
            $table->json('content_translations')->nullable()->after('content');
            $table->json('meta_title_translations')->nullable()->after('meta_title');
            $table->json('meta_description_translations')->nullable()->after('meta_description');
        });

        // Ajouter les colonnes de traduction pour blog_categories
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->json('name_translations')->nullable()->after('name');
            $table->json('description_translations')->nullable()->after('description');
        });

        // Ajouter les colonnes de traduction pour blog_tags
        Schema::table('blog_tags', function (Blueprint $table) {
            $table->json('name_translations')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['title_translations', 'excerpt_translations', 'content_translations', 'meta_title_translations', 'meta_description_translations']);
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn(['name_translations', 'description_translations']);
        });

        Schema::table('blog_tags', function (Blueprint $table) {
            $table->dropColumn('name_translations');
        });
    }
};
