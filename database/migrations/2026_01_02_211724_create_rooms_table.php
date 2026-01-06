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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->boolean('is_available')->default(true); 
            $table->text('description');
            $table->integer('area');
            $table->integer('occupancy');
            $table->integer('bed_number');
            $table->decimal('price_per_night', 10, 2);
            $table->boolean('refundable')->default(false);
            $table->timestamps();

          
            $table->index('hotel_id');
            $table->index('price_per_night');
            $table->index('occupancy');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
