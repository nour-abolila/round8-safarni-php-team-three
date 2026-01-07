<?php

namespace App\Services\BookingServices\Cars;

use App\Helper\ApiResponse;
use App\Http\Resources\Cars\CarResource;
use App\Models\Car;
use App\Repositories\BookingRepositories\BookRepository;
use App\Repositories\BookingRepositories\Cars\CarRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CarService
{
    public function __construct(
        protected CarRepository $carRepository,
        protected BookRepository $bookRepository,
    ){}
    public function searchCars($search)
    {
        return CarResource::collection(
            $this->carRepository->searchCar($search)
        );
    }

    public function bookCar(array $data)
    {
        $car = $this->carRepository->find($data['car_id']);

        DB::beginTransaction();
        try {
            $this->proccessBooking($car,$data);

            DB::commit();

            return ApiResponse::success([
                'car' => new CarResource($car),
            ],
            message: 'Car booked successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            return ApiResponse::error([
                'error' => $e->getMessage(),
            ],  'Failed to book car', 500);
        }
    }

    private function proccessBooking($car,array $data)
    {
        $car->update(['is_available' => false]);

        $book = $this->createBooking([
            'total_amount' => $car->price * $data['quantity'],
        ]);

        $this->createBookingDetails($book->id,$car,$data);
    }

    private function createBooking(array $data)
    {
        return $this->bookRepository->createBooking([
            'user_id' => auth()->user()->id,
            'booking_status' => 'pending',
            'total_amount' => $data['total_amount'],
            'payment_status' => 'pending',
        ]);
    }

    private function createBookingDetails($bookingId,Car $car, array $data)
    {
        return $this->bookRepository->createDetails([
            'booking_id' => $bookingId,
            'bookable_id' => $car->id,
            'bookable_type' => get_class($car),
            'quantity' => $data['quantity'],
            'price_paid' => $car->price,
            'additional_info' => [],
        ]);
    }
}
