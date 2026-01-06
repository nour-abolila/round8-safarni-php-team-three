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
        return Car::find($id);
    }

    public function searchCar($search): Collection
    {
        return Car::where('brand', 'like', "%$search%")
            ->orWhere('model', 'like', "%$search%")
            ->orWhere('model_year', $search)
            ->orWhere('vehicle_class', 'like', "%$search%")
            ->orWhere('seat_count', $search)
            ->orWhere('door_count', $search)
            ->orWhere('fuel_type', 'like', "%$search%")
            ->orWhere('transmission', 'like', "%$search%")
            ->orWhere('luggage_capacity', $search)
            ->orWhere('has_ac', $search)
            ->orWhere('location', 'like', "%$search%")
            ->orWhere('features', 'like', "%$search%")
            ->orWhere('is_available', $search)
            ->get();
    }
}
