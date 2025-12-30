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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('rental_item_id')->nullable()->after('product_variant_id')->constrained('rental_items')->onDelete('cascade');
            $table->enum('item_type', ['product', 'rental'])->default('product')->after('rental_item_id');
            $table->date('rental_start_date')->nullable()->after('item_type');
            $table->date('rental_end_date')->nullable()->after('rental_start_date');
            $table->integer('rental_duration_days')->nullable()->after('rental_end_date');
            $table->decimal('rental_deposit', 10, 2)->nullable()->after('rental_duration_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['rental_item_id']);
            $table->dropColumn([
                'rental_item_id',
                'item_type',
                'rental_start_date',
                'rental_end_date',
                'rental_duration_days',
                'rental_deposit'
            ]);
        });
    }
};
