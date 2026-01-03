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
        // الحصول على معرفات الفئات
        $economyCategory = DB::table('categories')->where('key', 'cars_economy')->first();
        $suvCategory = DB::table('categories')->where('key', 'cars_suv')->first();
        $luxuryCategory = DB::table('categories')->where('key', 'cars_luxury')->first();

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

        // إحداثيات عشوائية في السعودية
        $saudiCoordinates = [
            ['lat' => 24.7136, 'lng' => 46.6753], // الرياض
            ['lat' => 21.4858, 'lng' => 39.1925], // جدة
            ['lat' => 26.4207, 'lng' => 50.0888], // الدمام
            ['lat' => 24.4667, 'lng' => 39.6000], // المدينة المنورة
            ['lat' => 26.2361, 'lng' => 50.0393], // الخبر
        ];

        for ($i = 1; $i <= 30; $i++) {
            $brand = $brands[array_rand($brands)];
            $model = $modelsByBrand[$brand][array_rand($modelsByBrand[$brand])];

            // تحديد الفئة بناءً على الماركة والموديل
            if (in_array($brand, ['BMW', 'Mercedes'])) {
                $categoryId = $luxuryCategory->id;
                $vehicleClass = 'Luxury';
            } elseif (in_array($model, ['RAV4', 'CR-V', 'Explorer', 'X5', 'GLC', 'Tucson', 'Sportage', 'Rogue', 'Equinox'])) {
                $categoryId = $suvCategory->id;
                $vehicleClass = 'SUV';
            } else {
                $categoryId = $economyCategory->id;
                $vehicleClass = in_array($model, ['Camry', 'Accord', 'Sonata', 'Optima', 'Altima', 'Malibu']) ? 'Midsize' : 'Compact';
            }

            $location = $saudiCoordinates[array_rand($saudiCoordinates)];

            $cars[] = [
                'brand' => $brand,
                'model' => $model,
                'model_year' => rand(2019, 2024),
                'vehicle_class' => $vehicleClass,
                'seat_count' => $vehicleClass === 'SUV' ? rand(5, 7) : ($vehicleClass === 'Luxury' ? 5 : rand(4, 5)),
                'door_count' => 4,
                'fuel_type' => $fuelTypes[array_rand($fuelTypes)],
                'transmission' => $transmissions[array_rand($transmissions)],
                'luggage_capacity' => $vehicleClass === 'SUV' ? rand(3, 5) : ($vehicleClass === 'Luxury' ? rand(2, 4) : rand(1, 3)),
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
                'is_available' => true,
                'category_id' => $categoryId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('cars')->insert($cars);
    }
}
