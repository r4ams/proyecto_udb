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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->nullable()->constrained('tables')->onDelete('set null'); // Relation with tables
            $table->string('customer_name')->nullable(); // Customer name for the order
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending'); // Order status
            $table->text('comments')->nullable(); // Optional comments about the order
            $table->decimal('total', 10, 2)->default(0); // Total order cost
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
