<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Category = DB::table('categories')->where('key', 'flights')->first();

        $flights = [];
        $airports = ['JED', 'RUH', 'DMM', 'MED', 'CAI', 'DXB', 'AUH', 'DOH', 'IST', 'LHR'];
        $aircraftTypes = ['Boeing 737', 'Airbus A320', 'Boeing 787', 'Airbus A350', 'Boeing 777'];
        $bookingClasses = ['Economy', 'Business', 'First'];

        for ($i = 1; $i <= 50; $i++) {
            $departureDate = Carbon::now()->addDays(rand(1, 90))->addHours(rand(0, 23));
            $duration = rand(60, 600); // 1 hour to 10 hours
            $arrivalDate = (clone $departureDate)->addMinutes($duration);

            $departureAirport = $airports[array_rand($airports)];
            $arrivalAirport = $airports[array_rand($airports)];

            while ($arrivalAirport === $departureAirport) {
                $arrivalAirport = $airports[array_rand($airports)];
            }

            $basePrice = rand(500, 3000);
            $taxes = $basePrice * 0.15;
            $totalPrice = $basePrice + $taxes;

            $categoryId = $Category->id;

            $currentPrice = $basePrice * (1 + (rand(-10, 10) / 100));

            $flights[] = [
                'flight_number' => 'SV' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'departure_airport_code' => $departureAirport,
                'arrival_airport_code' => $arrivalAirport,
                'scheduled_departure' => $departureDate,
                'scheduled_arrival' => $arrivalDate,
                'departure_date' => $departureDate->toDateString(),
                'arrival_date' => $arrivalDate->toDateString(),
                'duration_minutes' => $duration,
                'aircraft_type' => $aircraftTypes[array_rand($aircraftTypes)],
                'booking_class' => $bookingClasses[array_rand($bookingClasses)],
                'base_price' => $basePrice,
                'total_price' => $totalPrice,
                'total_seats' => rand(20, 50),
                'booked_seats' => rand(10, 20),
                'current_price' => $currentPrice,
                'price_last_updated' => Carbon::now()->subHours(rand(1, 24)),
                'category_id' => $categoryId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('flights')->insert($flights);
    }
}
