<?php

namespace App\Http\Requests\Favorites;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavoriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tour_id' => ['required', 'exists:tours,id'],
        ];
    }
}

