<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Payment;
use App\Repositories\BookingRepositories\BookRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class PaymentWebhookController extends Controller
{
    public function __construct(
        protected BookRepository $bookingsRepositories,
    )
    {}
    public function handle(Request $request)
    {
        Log::info('Stripe webhook received', $request->all());

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

    try {
        $event = Webhook::constructEvent($payload, $sigHeader, $secret);
    } catch (\Throwable $e) {
        return response()->json(['error' => 'Invalid signature'], 400);
    }

        // $event = $request->input('type');
        // $intent = $request->input('data.object');

        $intent = $event->data->object;

        if ($event === 'payment_intent.succeeded') {
            Log::info('Payment Intent Succeeded',  $intent);

            $payment = Payment::where('transaction_id', $intent['id'])->firstOrFail();

            if ($payment) {
                $payment->update([
                    'status' => 'success',
                    'response' => $intent
                ]);
                $payment->booking->update(['status' => 'completed']);

                $this->unLockSeat($payment->booking);

            }
            return response()->json([
                'ok' => true,
            ]);
        }

        if ($event === 'payment_intent.payment_failed') {

            $payment = Payment::where('transaction_id', $intent['id'])->firstOrFail();

            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                    'response' => $intent
                ]);

                $payment->booking->update([
                    'status' => 'failed'
                ]);

                $this->unLockSeat($payment->booking);

            }
            return response()->json(['ok' => false]);
        }

    }

    private function unLockSeat($booking)
    {
        if( $booking->bookingDetails->bookable_type === Flight::class)
        {
            $seats = $booking->bookingDetails->additional_info['seats'];
            foreach ($seats as $seat) {
                $seat->unlock();
            }
        }
    }
}
