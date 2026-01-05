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
       Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location'); 
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->text('content_info')->nullable();
            $table->text('description');
            $table->string('slug')->unique();
            $table->json('amenities')->nullable();
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
            
            $table->index(['lat', 'lng']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
