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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');
            $table->string('departure_airport_code');
            $table->string('arrival_airport_code');
            $table->dateTime('scheduled_departure');
            $table->dateTime('scheduled_arrival');
            $table->date('departure_date');
            $table->date('arrival_date');
            $table->integer('duration_minutes');
            $table->string('aircraft_type');
            $table->string('booking_class');
            $table->decimal('base_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->integer('booked_seats');
            $table->decimal('current_price', 10, 2);
            $table->timestamp('price_last_updated');
            $table->foreignId('category_id')->constrained();
            $table->integer('total_seats')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
