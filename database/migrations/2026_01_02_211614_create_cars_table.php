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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->year('model_year');
            $table->string('vehicle_class');
            $table->integer('seat_count');
            $table->integer('door_count');
            $table->string('fuel_type');
            $table->string('transmission');
            $table->integer('luggage_capacity');
            $table->boolean('has_ac')->default(true);
            $table->decimal('current_location_lat', 10, 7);
            $table->decimal('current_location_lng', 10, 7);
            $table->json('features')->nullable();
            $table->boolean('is_available')->default(true);
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
