<?php

namespace App\Repositories\BookingRepositories\Cars;

use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

class CarRepository
{
    public function all()
    {
        return Car::all();
    }

    public function find($id)
    {
        return Car::findOrFail($id);
    }

    public function searchCar($search): Collection
    {
        return Car::where('brand', 'like', "%$search%")
            ->orWhere('model', 'like', "%$search%")
            ->orWhere('model_year', $search)
            ->orWhere('vehicle_class', $search)
            ->orWhere('fuel_type', 'like', "%$search%")
            ->orWhere('location', 'like', "%$search%")
            ->Where('is_available', true)
            ->get();
    }
}
