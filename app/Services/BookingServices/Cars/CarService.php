<?php

namespace App\Services\BookingServices;

use App\Http\Resources\Cars\CarResource;
use App\Models\Car;
use App\Repositories\BookingRepositories\Cars\CarRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CarService
{
    public function __construct(
        protected CarRepository $carRepository
    ){}
    public function searchCars($search)
    {
        return CarResource::collection(
            $this->carRepository->searchCar($search)
        );
    }
}
