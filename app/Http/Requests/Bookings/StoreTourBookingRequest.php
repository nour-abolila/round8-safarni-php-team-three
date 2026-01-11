<?php

namespace App\Http\Requests\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourBookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tour_id' => 'required|exists:tours,id',
            'tour_schedule_id' => 'required|exists:tour_schedules,id',
            'quantity' => 'required|integer|min:1|max:10',
            'payment_method' => 'required|string|in:credit_card,paypal,cash',
            'special_requests' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'tour_id.required' => 'معرف الجولة مطلوب',
            'tour_id.exists' => 'الجولة المحددة غير موجودة',
            'tour_schedule_id.required' => 'معرف جدول الجولة مطلوب',
            'tour_schedule_id.exists' => 'جدول الجولة المحدد غير موجود',
            'quantity.required' => 'عدد الأشخاص مطلوب',
            'quantity.integer' => 'عدد الأشخاص يجب أن يكون رقمًا صحيحًا',
            'quantity.min' => 'عدد الأشخاص يجب أن يكون على الأقل 1',
            'quantity.max' => 'عدد الأشخاص لا يمكن أن يتجاوز 10',
            'payment_method.required' => 'طريقة الدفع مطلوبة',
            'payment_method.in' => 'طريقة الدفع يجب أن تكون واحدة من: credit_card, paypal, cash',
            'special_requests.max' => 'الطلبات الخاصة لا يمكن أن تتجاوز 500 حرف',
        ];
    }
}
