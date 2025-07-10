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
        
        // Check if this is a down payment (20% of total)
        $downPaymentAmount = $booking->total_price * 0.2;
        
        if ($booking->amount_paid >= $booking->amount_due) {
            // Full payment completed
            $booking->payment_status = 'paid';
            $booking->payment_due_date = null; // No more due dates
        } elseif ($booking->amount_paid >= $downPaymentAmount) {
            // Down payment completed, set full payment due date
            $booking->payment_status = 'partial';
            $booking->payment_due_date = $booking->event_date->subWeek(); // Due 1 week before event
        } else {
            // Still in down payment phase
            $booking->payment_status = 'partial';
            // Keep the original down payment due date
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
