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
        Schema::create('rental_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_number')->unique();
            $table->foreignId('rental_item_id')->constrained('rental_items')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_days');
            $table->integer('quantity_reserved')->default(1);
            $table->enum('rate_type', ['daily', 'weekly', 'monthly']);
            $table->decimal('rate_applied', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('deposit', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending');
            $table->date('actual_return_date')->nullable();
            $table->text('return_notes')->nullable();
            $table->string('return_condition')->nullable();
            $table->timestamps();

            $table->index(['rental_item_id', 'status', 'start_date', 'end_date'], 'idx_reservations_availability');
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_reservations');
    }
};
