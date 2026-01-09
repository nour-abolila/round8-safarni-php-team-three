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

        $images = [
            'https://4kwallpapers.com/images/walls/thumbs_2t/24979.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/25034.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24980.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24890.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24822.jpeg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24866.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24800.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24986.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24879.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24705.jpeg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24889.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24672.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24841.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24638.jpeg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24533.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24533.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24670.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24495.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24412.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24461.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24428.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24420.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24441.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24407.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24441.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24383.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24415.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24403.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24423.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24422.jpg'
        ];

        $additionalImages = [
            'https://4kwallpapers.com/images/walls/thumbs_2t/24397.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24392.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24386.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24379.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24375.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24368.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24362.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24358.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24352.jpg',
            'https://4kwallpapers.com/images/walls/thumbs_2t/24345.jpg',
        ];

        $allImages = array_merge($images, $additionalImages);
        $totalImages = count($allImages);

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

        $saudiLocations = [
            [
                'city' => 'الرياض',
                'lat' => 24.7136,
                'lng' => 46.6753,
                'district' => ['الملك فهد', 'الملز', 'العليا', 'النخيل']
            ],
            [
                'city' => 'جدة',
                'lat' => 21.4858,
                'lng' => 39.1925,
                'district' => ['الحمراء', 'السلامة', 'الثغر', 'الروضة']
            ],
            [
                'city' => 'الدمام',
                'lat' => 26.4207,
                'lng' => 50.0888,
                'district' => ['الخبر', 'الظهران', 'العليا', 'الراكة']
            ],
            [
                'city' => 'المدينة المنورة',
                'lat' => 24.4667,
                'lng' => 39.6000,
                'district' => ['العقيق', 'العيون', 'الخالدية', 'المناخة']
            ],
            [
                'city' => 'الخبر',
                'lat' => 26.2361,
                'lng' => 50.0393,
                'district' => ['الشاطئ', 'الجبيلة', 'الراكة', 'النخيل']
            ],
            [
                'city' => 'مكة المكرمة',
                'lat' => 21.4225,
                'lng' => 39.8262,
                'district' => ['العزيزية', 'الششة', 'النسيم', 'الزاهر']
            ],
            [
                'city' => 'الطائف',
                'lat' => 21.2783,
                'lng' => 40.4203,
                'district' => ['الشوقية', 'القيم', 'الحوية', 'الهدا']
            ],
            [
                'city' => 'تبوك',
                'lat' => 28.3654,
                'lng' => 36.6189,
                'district' => ['المصيف', 'النخيل', 'الروضة', 'العزيزية']
            ],
            [
                'city' => 'أبها',
                'lat' => 18.2404,
                'lng' => 42.6566,
                'district' => ['النصب', 'المفتاحة', 'السلام', 'المنتزه']
            ],
            [
                'city' => 'حائل',
                'lat' => 27.5114,
                'lng' => 41.7208,
                'district' => ['الاندلس', 'السلام', 'المصيف', 'النقرة']
            ]
        ];

        for ($i = 1; $i <= 30; $i++) {
            $brand = $brands[array_rand($brands)];
            $model = $modelsByBrand[$brand][array_rand($modelsByBrand[$brand])];

            $vehicleClass = $this->determineVehicleClass($brand, $model);
            $locationData = $saudiLocations[array_rand($saudiLocations)];

            $district = $locationData['district'][array_rand($locationData['district'])];
            $streetNumber = rand(1, 999);

            $formattedLocation = sprintf(
                "%s، حي %s، شارع %s %d",
                $locationData['city'],
                $district,
                $this->generateStreetName(),
                $streetNumber
            );

            $seatCount = $this->determineSeatCount($vehicleClass);
            $luggageCapacity = $this->determineLuggageCapacity($vehicleClass);

            $power = $this->determinePower($vehicleClass, $brand, $model);
            $maxSpeed = $this->determineMaxSpeed($vehicleClass, $brand, $model);
            $acceleration = $this->determineAcceleration($vehicleClass, $brand, $model);

            $price = $this->determinePrice($vehicleClass, $brand, $model, $power, $maxSpeed, $acceleration);

            $lat = $locationData['lat'] + (rand(-50, 50) / 1000);
            $lng = $locationData['lng'] + (rand(-50, 50) / 1000);

            $cars[] = [
                'brand' => $brand,
                'model' => $model,
                'model_year' => rand(2019, 2024),
                'vehicle_class' => $vehicleClass,
                'seat_count' => $seatCount,
                'door_count' => 4,
                'fuel_type' => $fuelTypes[array_rand($fuelTypes)],
                'power' => $power,
                'max_speed' => $maxSpeed,
                'acceleration' => $acceleration,
                'transmission' => $transmissions[array_rand($transmissions)],
                'luggage_capacity' => $luggageCapacity,
                'has_ac' => true,
                'current_location_lat' => $lat,
                'current_location_lng' => $lng,
                'price' => $price,
                'location' => $formattedLocation,
                'features' => json_encode([
                    'bluetooth' => rand(0, 1) ? true : false,
                    'navigation' => rand(0, 1) ? true : false,
                    'sunroof' => $vehicleClass === 'Luxury' ? true : (rand(0, 1) ? true : false),
                    'leather_seats' => $vehicleClass === 'Luxury' ? true : false,
                    'backup_camera' => true,
                    'usb_ports' => rand(2, 4),
                    'cruise_control' => $vehicleClass === 'Luxury' ? true : (rand(0, 1) ? true : false),
                    'parking_sensors' => rand(0, 1) ? true : false,
                    'lane_assist' => $vehicleClass === 'Luxury' ? true : (rand(0, 1) ? true : false),
                    'blind_spot_monitor' => $vehicleClass === 'Luxury' ? true : (rand(0, 1) ? true : false),
                ]),
                'is_available' => rand(0, 1) ? true : false,
                'category_id' => $category->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('cars')->insert($cars);
        $this->command->info('✅ تم إنشاء ' . count($cars) . ' سيارة مع جميع البيانات الفنية والأسعار بنجاح!');

        $this->addImagesToCars($allImages, $totalImages);
    }
    private function addImagesToCars(array $allImages, int $totalImages): void
    {
        $cars = DB::table('cars')->get();
        $imageRecords = [];

        foreach ($cars as $car) {
            $selectedImageIndexes = array_rand($allImages, 3);

            if (!is_array($selectedImageIndexes)) {
                $selectedImageIndexes = [$selectedImageIndexes];
            }

            foreach ($selectedImageIndexes as $index) {
                $imageRecords[] = [
                    'imageable_id' => $car->id,
                    'imageable_type' => 'App\Models\Car',
                    'url' => $allImages[$index],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('images')->insert($imageRecords);
        $this->command->info('✅ تم إضافة ' . count($imageRecords) . ' صورة للسيارات (3 صور لكل سيارة)');
    }

    private function addImagesToCarsWithVariety(array $allImages): void
    {
        $cars = DB::table('cars')->get();
        $imageRecords = [];

        $imagesPerCar = 3;
        $totalCars = count($cars);
        $totalNeededImages = $totalCars * $imagesPerCar;

        $imageIndexes = [];
        for ($i = 0; $i < $totalNeededImages; $i++) {
            $imageIndexes[] = $i % count($allImages);
        }

        shuffle($imageIndexes);

        $currentIndex = 0;
        foreach ($cars as $car) {
            for ($j = 0; $j < $imagesPerCar; $j++) {
                if ($currentIndex < count($imageIndexes)) {
                    $imageIndex = $imageIndexes[$currentIndex];
                    $imageRecords[] = [
                        'imageable_id' => $car->id,
                        'imageable_type' => 'App\Models\Car',
                        'url' => $allImages[$imageIndex],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    $currentIndex++;
                }
            }
        }

        DB::table('images')->insert($imageRecords);
        $this->command->info('✅ تم إضافة ' . count($imageRecords) . ' صورة متنوعة للسيارات');
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

    private function determinePower(string $vehicleClass, string $brand, string $model): int
    {
        $powerRanges = [
            'Compact' => ['min' => 100, 'max' => 150],
            'Sedan' => ['min' => 150, 'max' => 250],
            'SUV' => ['min' => 200, 'max' => 350],
            'Luxury' => ['min' => 250, 'max' => 500],
        ];

        $range = $powerRanges[$vehicleClass];

        $additionalPower = 0;

        if (in_array($model, ['Land Cruiser', 'X5', 'GLE', 'Tahoe', 'Explorer'])) {
            $additionalPower += 30;
        }

        if (in_array($brand, ['BMW', 'Mercedes'])) {
            $additionalPower += 20;
        }

        $isElectric = rand(0, 10) > 7;
        if ($isElectric) {
            $additionalPower += 50;
        }

        return rand($range['min'], $range['max']) + $additionalPower;
    }

    private function determineMaxSpeed(string $vehicleClass, string $brand, string $model): int
    {
        $speedRanges = [
            'Compact' => ['min' => 160, 'max' => 180],
            'Sedan' => ['min' => 180, 'max' => 220],
            'SUV' => ['min' => 180, 'max' => 210],
            'Luxury' => ['min' => 220, 'max' => 280],
        ];

        $range = $speedRanges[$vehicleClass];

        $additionalSpeed = 0;

        if (in_array($model, ['Camry V6', 'Accord Sport', '3 Series M', 'C-Class AMG'])) {
            $additionalSpeed += 20;
        }

        if (in_array($brand, ['BMW', 'Mercedes'])) {
            $additionalSpeed += 15;
        }

        return rand($range['min'], $range['max']) + $additionalSpeed;
    }

    private function determineAcceleration(string $vehicleClass, string $brand, string $model): float
    {
        $accelerationRanges = [
            'Compact' => ['min' => 10.0, 'max' => 14.0],
            'Sedan' => ['min' => 8.0, 'max' => 12.0],
            'SUV' => ['min' => 9.0, 'max' => 13.0],
            'Luxury' => ['min' => 5.0, 'max' => 8.0],
        ];

        $range = $accelerationRanges[$vehicleClass];

        $improvement = 0;

        if (in_array($model, ['3 Series', 'C-Class', 'Accord', 'Camry'])) {
            $improvement -= 1.5;
        }

        if (in_array($brand, ['BMW', 'Mercedes'])) {
            $improvement -= 2.0;
        }

        $isElectric = rand(0, 10) > 7;
        if ($isElectric) {
            $improvement -= 3.0;
        }

        $acceleration = rand($range['min'] * 10, $range['max'] * 10) / 10;
        $acceleration += $improvement;

        return max(4.0, round($acceleration, 1));
    }
    private function determinePrice(string $vehicleClass, string $brand, string $model, int $power, int $maxSpeed, float $acceleration): float
    {
        $basePrices = [
            'Compact' => 40000,
            'Sedan' => 60000,
            'SUV' => 80000,
            'Luxury' => 120000,
        ];

        $price = $basePrices[$vehicleClass];

        $brandMultipliers = [
            'Toyota' => 1.0,
            'Honda' => 1.1,
            'Ford' => 1.05,
            'Hyundai' => 0.95,
            'Kia' => 0.9,
            'Nissan' => 1.0,
            'Chevrolet' => 1.0,
            'BMW' => 1.5,
            'Mercedes' => 1.6,
        ];

        $price *= $brandMultipliers[$brand] ?? 1.0;

        $modelAdjustments = [
            'Land Cruiser' => 80000,
            'X5' => 70000,
            'GLE' => 75000,
            '3 Series' => 20000,
            '5 Series' => 30000,
            'C-Class' => 25000,
            'E-Class' => 35000,
            'GLC' => 30000,

            'RAV4' => 5000,
            'CR-V' => 4000,
            'Explorer' => 10000,
            'Tucson' => 3000,
            'Santa Fe' => 6000,
            'Rogue' => 4000,
            'Equinox' => 5000,
            'Tahoe' => 20000,
            'Pathfinder' => 8000,

            'Camry' => 3000,
            'Accord' => 3500,
            'Sonata' => 2000,
            'Optima' => 2500,
            'Altima' => 2800,
            'Malibu' => 3000,
            'Fusion' => 3200,

            'Corolla' => 1000,
            'Civic' => 1500,
            'Focus' => 800,
            'Elantra' => 700,
            'Cruze' => 900,
            'Sentra' => 950,
            'Yaris' => -1000,
        ];

        $price += $modelAdjustments[$model] ?? 0;

        $currentYear = date('Y');
        $carYear = rand(2019, 2024);
        $yearDifference = $currentYear - $carYear;
        $yearDiscount = $yearDifference * 0.05;
        $price *= (1 - $yearDiscount);

        $powerBonus = floor($power / 50) * 0.05;
        $price *= (1 + $powerBonus);

        $speedBonus = floor($maxSpeed / 50) * 0.03;
        $price *= (1 + $speedBonus);

        $accelerationBonus = 0;
        if ($acceleration < 6.0) $accelerationBonus += 0.15;
        elseif ($acceleration < 8.0) $accelerationBonus += 0.10;
        elseif ($acceleration < 10.0) $accelerationBonus += 0.05;

        $price *= (1 + $accelerationBonus);

        $fuelMultipliers = [
            'Gasoline' => 1.0,
            'Diesel' => 1.1,
            'Hybrid' => 1.2,
            'Electric' => 1.4,
        ];
        $fuelType = $this->getRandomFuelType();
        $price *= $fuelMultipliers[$fuelType] ?? 1.0;

        $randomFactor = 1 + (rand(-10, 10) / 100);
        $price *= $randomFactor;

        $price = round($price / 1000) * 1000;

        return max(30000, min(400000, $price));
    }

    private function getRandomFuelType(): string
    {
        $fuelTypes = ['Gasoline', 'Diesel', 'Hybrid', 'Electric'];
        $weights = [40, 20, 25, 15];

        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);

        $currentWeight = 0;
        for ($i = 0; $i < count($fuelTypes); $i++) {
            $currentWeight += $weights[$i];
            if ($random <= $currentWeight) {
                return $fuelTypes[$i];
            }
        }

        return 'Gasoline';
    }

    private function generateStreetName(): string
    {
        $streetNames = [
            'الملك فهد', 'الملك عبدالله', 'الملك سلمان', 'الجامعة', 'الخليج',
            'النهضة', 'السلام', 'الرياض', 'التحلية', 'الروضة',
            'النخيل', 'العليا', 'الملز', 'الغدير', 'اليرموك',
            'الاندلس', 'الزهور', 'الفيحاء', 'الخزان', 'الربيع'
        ];

        return $streetNames[array_rand($streetNames)];
    }
}
