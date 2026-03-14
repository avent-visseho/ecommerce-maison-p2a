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
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('long_description')->nullable();
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('weekly_rate', 10, 2)->nullable();
            $table->decimal('monthly_rate', 10, 2)->nullable();
            $table->integer('min_rental_days')->default(1);
            $table->integer('max_rental_days')->nullable();
            $table->decimal('deposit_amount', 10, 2)->default(0);
            $table->string('sku')->unique();
            $table->integer('quantity')->default(0);
            $table->foreignId('rental_category_id')->constrained('rental_categories')->onDelete('cascade');
            $table->string('main_image')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'quantity']);
            $table->index('rental_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
