<?php

namespace App\Repositories\Payment;

use App\Models\Payment;

class PaymentRepository
{
    public function create($data)
    {
        return Payment::create($data);
    }
}
