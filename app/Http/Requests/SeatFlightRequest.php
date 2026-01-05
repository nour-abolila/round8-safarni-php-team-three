<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatFlightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'integer|exists:flight_seats,id',
        ];
    }
}
