<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class searchFlightRequest extends FormRequest
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
            'from' => 'required',
            'to' => 'required',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'sometimes|date|after_or_equal:departure_date',
            'passengers' => 'required|integer|min:1',
            'type' => 'required|in:one-way,round-trip',
        ];
    }
}
