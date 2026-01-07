<?php

namespace App\Http\Requests\Tours;

use Illuminate\Foundation\Http\FormRequest;

class CompareToursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tour_ids' => ['required', 'array', 'min:2', 'max:2'],
            'tour_ids.*' => ['exists:tours,id'],
        ];
    }
}

