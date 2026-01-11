<?php

namespace App\Services\Payment;

use App\Helper\ApiResponse;
use App\Http\Resources\Payments\PaymentResource;
use App\Repositories\BookingRepositories\BookRepository;
use App\Repositories\Payment\PaymentRepository;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentService
{
    public function __construct(
        protected BookRepository $bookingsRepositories,
        protected PaymentRepository $paymentRepository
    ){}
    public function makePayment($bookingId)
    {
        $booking = $this->bookingsRepositories->find($bookingId);

        $payment = $this->createPaymentIntentForBooking($booking);

        return ApiResponse::success([
           new PaymentResource($payment)
        ],
            'Payment intent created successfully',
            200);
    }

    public function createPaymentIntentForBooking($booking)
    {
        $pay = $this->pay($booking->total_amount);

        $payment = $this->createPayment($booking, $pay['transaction_id']);

        $payment->client_secret = $pay['client_secret'];
        $payment->publishable_key = $pay['publishable_key'];

        return $payment;
    }

    private function createPayment($booking, $transactionId)
    {
        return $this->paymentRepository->create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_amount,
            'status' => 'pending',
            'transaction_id' => $transactionId,
            'payment_method' => 'stripe',
        ]);
    }

    private function pay($amount)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => (int) ($amount * 100),
            'currency' => 'usd',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return [
            'status' => 'pending',
            'transaction_id' => $intent->id,
            'client_secret' => $intent->client_secret,
            'publishable_key' => config('services.stripe.key'),
        ];
    }
}
