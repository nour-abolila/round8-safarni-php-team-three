<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class HotelReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
  

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
          
            'hotel_id' => ['required', 'exists:hotels,id'],
          
            'rating'   => ['required', 'integer', 'between:1,5'],
          
            'comment'  => ['nullable', 'string'],
        ];
    }
}


