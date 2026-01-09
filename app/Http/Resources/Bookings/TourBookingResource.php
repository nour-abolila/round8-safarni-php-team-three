<?php

namespace App\Http\Resources\Bookings;

use Illuminate\Http\Resources\Json\JsonResource;

class TourBookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'booking_number' => 'BK-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
            'tour_details' => $this->getTourDetails(),
            'total_amount' => number_format($this->total_amount, 2),
            'booking_status' => $this->booking_status,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    private function getTourDetails()
    {
        $tourDetail = $this->details->firstWhere('bookable_type', 'App\Models\Tour');
        
        if (!$tourDetail) {
            return null;
        }

        $tour = $tourDetail->bookable;
        $scheduleId = $tourDetail->additional_info['schedule_id'] ?? null;
        $schedule = $tour->schedules->find($scheduleId);

        return [
            'tour_id' => $tour->id,
            'tour_title' => $tour->title,
            'tour_slug' => $tour->slug,
            'duration' => $tour->duration,
            'visit_season' => $tour->visit_season,
            'activities' => $tour->activities,
            'quantity' => $tourDetail->quantity,
            'price_per_person' => number_format($tourDetail->price_paid / $tourDetail->quantity, 2),
            'schedule' => $schedule ? [
                'id' => $schedule->id,
                'start_date' => $schedule->start_date,
                'end_date' => $schedule->end_date,
                'available_slots' => $schedule->available_slots,
            ] : null,
            'main_image' => $tour->images->first()?->url,
        ];
    }
}