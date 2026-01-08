<?php

namespace App\Http\Resources\Payments;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'transaction_id' => $this->transaction_id,
            'status' => $this->status,
            'publishable_key' => $this->publishable_key,
            'client_secret' => $this->client_secret,
            'payment_method' => $this->payment_method
        ];
    }
}
