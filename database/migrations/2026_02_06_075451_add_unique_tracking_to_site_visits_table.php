<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Nettoyer les données biaisées existantes
        DB::table('site_visits')->truncate();

        Schema::table('site_visits', function (Blueprint $table) {
            $table->boolean('is_unique_visit')->default(true)->after('visited_at');
            $table->unsignedInteger('page_views')->default(1)->after('is_unique_visit');

            // Index pour optimiser les requêtes de vérification
            $table->index(['ip_address', 'user_agent', 'visited_at'], 'ip_ua_visited_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_visits', function (Blueprint $table) {
            $table->dropIndex('ip_ua_visited_idx');
            $table->dropColumn(['is_unique_visit', 'page_views']);
        });
    }
};
