<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class FixBookingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:fix-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix payment amounts for approved bookings that have incorrect amount_due';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for bookings with incorrect payment amounts...');

        // Find approved bookings where amount_due is 0 but total_price is not 0
        $bookings = Booking::where('status', 'approved')
            ->where('amount_due', 0)
            ->where('total_price', '>', 0)
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('No bookings found that need fixing.');
            return;
        }

        $this->info("Found {$bookings->count()} bookings that need fixing.");

        foreach ($bookings as $booking) {
            $oldAmountDue = $booking->amount_due;
            $booking->amount_due = $booking->total_price;
            $booking->save();

            $this->info("Fixed booking ID {$booking->id} ({$booking->event_name}): amount_due changed from ₱{$oldAmountDue} to ₱{$booking->amount_due}");
        }

        $this->info('Payment amounts have been fixed successfully!');
    }
} 