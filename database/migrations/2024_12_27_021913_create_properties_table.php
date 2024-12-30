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
        Schema::create('properties', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('property_category_id')->constrained();
            $table->foreignUlid('owner_id')->nullable()->references('id')->on('people')->nullOnDelete();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('registration_no');
            $table->string('registration_code')->unique();
            $table->timestamp('registration_date')->default(now());
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
