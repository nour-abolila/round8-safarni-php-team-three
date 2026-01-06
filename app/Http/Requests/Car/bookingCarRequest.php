<?php

namespace App\Http\Requests\Car;

use App\Helper\ApiResponse;
use App\Models\BookingDetail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class bookingCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'begin_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:begin_date',
            'car_id' => 'required|exists:cars,id',
        ];
    }

    public function withValidator(Validator $validator)
{
    $validator->after(function ($validator) {
        $beginDate = $this->input('begin_date');
        $endDate = $this->input('end_date');
        $carId = $this->input('car_id');

        $bookings = BookingDetail::where('bookable_id', $carId)
            ->where('bookable_type', 'App\Models\Car')
            ->where(function ($query) use ($beginDate, $endDate) {
                $query->where(function ($q) use ($beginDate, $endDate) {
                    // الوصول إلى JSON باستخدام ->>
                    $q->whereRaw("JSON_EXTRACT(additional_info, '$.begin_date') >= ?", [$beginDate])
                      ->whereRaw("JSON_EXTRACT(additional_info, '$.begin_date') <= ?", [$endDate]);
                })
                ->orWhere(function ($q) use ($beginDate, $endDate) {
                    $q->whereRaw("JSON_EXTRACT(additional_info, '$.end_date') >= ?", [$beginDate])
                      ->whereRaw("JSON_EXTRACT(additional_info, '$.end_date') <= ?", [$endDate]);
                })
                ->orWhere(function ($q) use ($beginDate, $endDate) {
                    $q->whereRaw("JSON_EXTRACT(additional_info, '$.begin_date') <= ?", [$beginDate])
                      ->whereRaw("JSON_EXTRACT(additional_info, '$.end_date') >= ?", [$endDate]);
                });
            })
            ->exists();

        if ($bookings) {
            $validator->errors()->add('car_id', 'The car is already reserved for the selected date range.');
        }
    });
}
}
