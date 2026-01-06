<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = DB::table('categories')->where('key', 'cars')->first();

        if (!$category) {
            throw new \Exception('يجب إنشاء تصنيف السيارات أولاً. قم بتشغيل CategorySeeder');
        }

        $cars = [];
        $brands = ['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes', 'Hyundai', 'Kia', 'Nissan', 'Chevrolet'];

        $modelsByBrand = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Land Cruiser', 'Yaris'],
            'Honda' => ['Accord', 'Civic', 'CR-V', 'Pilot'],
            'Ford' => ['Focus', 'Fusion', 'Explorer', 'Escape'],
            'BMW' => ['3 Series', '5 Series', 'X5', 'X3'],
            'Mercedes' => ['C-Class', 'E-Class', 'GLC', 'GLE'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe'],
            'Kia' => ['Optima', 'Sportage', 'Sorento', 'Telluride'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Pathfinder'],
            'Chevrolet' => ['Malibu', 'Cruze', 'Equinox', 'Tahoe'],
        ];

        $fuelTypes = ['Gasoline', 'Diesel', 'Hybrid', 'Electric'];
        $transmissions = ['Automatic', 'Manual'];

        $saudiCoordinates = [
            ['lat' => 24.7136, 'lng' => 46.6753],
            ['lat' => 21.4858, 'lng' => 39.1925],
            ['lat' => 26.4207, 'lng' => 50.0888],
            ['lat' => 24.4667, 'lng' => 39.6000],
            ['lat' => 26.2361, 'lng' => 50.0393],
        ];

        for ($i = 1; $i <= 30; $i++) {
            $brand = $brands[array_rand($brands)];
            $model = $modelsByBrand[$brand][array_rand($modelsByBrand[$brand])];

            $vehicleClass = $this->determineVehicleClass($brand, $model);

            $location = $saudiCoordinates[array_rand($saudiCoordinates)];

            $seatCount = $this->determineSeatCount($vehicleClass);

            $luggageCapacity = $this->determineLuggageCapacity($vehicleClass);

            $cars[] = [
                'brand' => $brand,
                'model' => $model,
                'model_year' => rand(2019, 2024),
                'vehicle_class' => $vehicleClass,
                'seat_count' => $seatCount,
                'door_count' => 4,
                'fuel_type' => $fuelTypes[array_rand($fuelTypes)],
                'transmission' => $transmissions[array_rand($transmissions)],
                'luggage_capacity' => $luggageCapacity,
                'has_ac' => true,
                'current_location_lat' => $location['lat'] + (rand(-100, 100) / 1000),
                'current_location_lng' => $location['lng'] + (rand(-100, 100) / 1000),
                'features' => json_encode([
                    'bluetooth' => rand(0, 1) ? true : false,
                    'navigation' => rand(0, 1) ? true : false,
                    'sunroof' => $vehicleClass === 'Luxury' ? true : (rand(0, 1) ? true : false),
                    'leather_seats' => $vehicleClass === 'Luxury' ? true : false,
                    'backup_camera' => true,
                ]),
                'is_available' => rand(0, 1) ? true : false, // بعض السيارات غير متاحة
                'category_id' => $category->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('cars')->insert($cars);
    }
    private function determineVehicleClass(string $brand, string $model): string
    {
        if (in_array($brand, ['BMW', 'Mercedes'])) {
            return 'Luxury';
        } elseif (in_array($model, ['RAV4', 'CR-V', 'Explorer', 'X5', 'GLC', 'Tucson', 'Sportage', 'Rogue', 'Equinox', 'Santa Fe', 'Pilot', 'Pathfinder', 'Tahoe'])) {
            return 'SUV';
        } elseif (in_array($model, ['Camry', 'Accord', 'Sonata', 'Optima', 'Altima', 'Malibu', 'Fusion'])) {
            return 'Sedan';
        } else {
            return 'Compact';
        }
    }
    private function determineSeatCount(string $vehicleClass): int
    {
        return match($vehicleClass) {
            'SUV' => rand(5, 7),
            'Luxury' => 5,
            'Sedan' => rand(4, 5),
            default => rand(4, 5),
        };
    }
    private function determineLuggageCapacity(string $vehicleClass): int
    {
        return match($vehicleClass) {
            'SUV' => rand(3, 5),
            'Luxury' => rand(2, 4),
            'Sedan' => rand(2, 3),
            default => rand(1, 2), 
        };
    }
}
