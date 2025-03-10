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
        Schema::create('payables', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('property_id')->constrained();
            $table->foreignUlid('property_category_id')->constrained();
            $table->string('viya_reference_no')->nullable()->unique();
            $table->string('receipt_no')->unique();
            $table->string('billed_period')->nullable();
            $table->datetime('due_date');
            $table->decimal('amount')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('fine')->default(0);
            $table->decimal('grand_total');
            $table->decimal('balance');
            $table->enum('state', ['pending', 'processing', 'paid', 'overdue', 'cancelled']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payables');
    }
};
