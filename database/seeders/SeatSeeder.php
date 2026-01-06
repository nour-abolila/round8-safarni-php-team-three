<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flights = DB::table('flights')->get();

        if ($flights->isEmpty()) {
            $this->command->error('⚠️ لا توجد رحلات في قاعدة البيانات. قم بتشغيل FlightSeeder أولاً.');
            return;
        }

        $seats = [];

        $seatLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
        $statuses = ['available', 'booked', 'locked'];
        $statusWeights = [70, 20, 10]; // 70% available, 20% booked, 10% locked

        foreach ($flights as $flight) {
            $totalSeats = rand(150, 300);

            $rows = ceil($totalSeats / count($seatLetters));

            for ($row = 1; $row <= $rows; $row++) {
                foreach ($seatLetters as $letter) {
                    if (count($seats) >= $totalSeats) {
                        break 2;
                    }

                    $seatNumber = $row . $letter;

                    $status = $this->getWeightedRandomStatus($statuses, $statusWeights);

                    $userId = null;
                    if ($status === 'booked') {
                        $randomUser = DB::table('users')->inRandomOrder()->first();
                        if ($randomUser) {
                            $userId = $randomUser->id;
                        }
                    }

                    $lockExpiry = null;
                    if ($status === 'locked') {
                        $lockExpiry = Carbon::now()->addMinutes(rand(5, 30));
                    }

                    $seats[] = [
                        'flight_id' => $flight->id,
                        'seat_number' => $seatNumber,
                        'status' => $status,
                        'lock_expiry' => $lockExpiry,
                        'user_id' => $userId,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
        }

        DB::table('flight_seats')->insert($seats);

        $this->command->info('✅ تم إنشاء ' . count($seats) . ' مقعد بنجاح!');
    }

    private function getWeightedRandomStatus(array $statuses, array $weights): string
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);

        $currentWeight = 0;
        for ($i = 0; $i < count($statuses); $i++) {
            $currentWeight += $weights[$i];
            if ($random <= $currentWeight) {
                return $statuses[$i];
            }
        }

        return $statuses[0];
    }
}
