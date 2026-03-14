<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter le champ prix aux valeurs d'attributs (pour les options checkbox)
        Schema::table('product_attribute_values', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('color_hex');
        });

        // Table pivot pour lier les attributs checkbox aux produits
        Schema::create('product_checkbox_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_attribute_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'product_attribute_id'], 'product_checkbox_attr_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_checkbox_attributes');

        Schema::table('product_attribute_values', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
