<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([


            CategorySeeder::class,
            
            UserSeeder::class,       
            
            HotelSeeder::class,
            
            RoomSeeder::class,
            
            ImageSeeder::class,

            FlightSeeder::class,
            
            CarSeeder::class,
            
            ReviewSeeder::class,
        ]);
    }
}
