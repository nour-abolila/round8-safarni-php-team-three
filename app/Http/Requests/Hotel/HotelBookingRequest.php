<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class HotelBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        
        return true;
    }

    public function rules(): array
    {
        return [
        
            'room_id'    => ['required', 'exists:rooms,id'],
        
            'check_in'   => ['required', 'date', 'after_or_equal:today'],
        
            'check_out'  => ['required', 'date', 'after:check_in'],
        
            'adults'     => ['required', 'integer', 'min:1'],
        
            'teens'      => ['nullable', 'integer', 'min:0'],
        
            'children'   => ['nullable', 'integer', 'min:0'],
        ];
    }
}
