<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showBookingPayment(Booking $booking)
    {
        // $this->authorize('pay', $booking); 
        return view('booking.pay', compact('booking'));
    }

    public function processBookingPayment(Request $request, Booking $booking)
    {
        //$this->authorize('pay', $booking);

        $user = $request->user();
        $amount = $request->input('amount'); // Should be validated

        // Stripe expects amount in cents
        $user->charge($amount * 100, $request->paymentMethod, [
            'payment_method_types' => ['card'], // <-- Only allow card payments
        ]);
        $reference = 'PAY-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

       Payment::create([
        'reference'  => $reference,
        'booking_id' => $booking->id,
        'user_id'    => $user->id,
        'amount'     => $amount,
        'paid_at'    => now(),
    ]);

        // Update booking
        $booking->amount_paid += $amount;
        if ($booking->amount_paid >= $booking->amount_due) {
            $booking->payment_status = 'paid';
        } elseif ($booking->amount_paid > 0) {
            $booking->payment_status = 'partial';
        }
        $booking->save();

       return redirect()->route('payment.success')->with('payment_reference', $reference);
    }

    public function paymentHistory()
{
    $user = Auth::user();
    $payments = Payment::where('user_id', $user->id)
        ->orderByDesc('paid_at')
        ->get();

    return view('user.payment.payment-history', compact('payments'));
}
}
