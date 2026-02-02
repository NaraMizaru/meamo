<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Auth;

class BookingObserver
{
    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        // Check if status changed to completed
        if ($booking->wasChanged('status') && $booking->status === 'completed') {
            // Create Income Transaction
            $transaction = Transaction::create([
                'type' => 'income',
                'amount' => $booking->total_price,
                'description' => "Pendapatan dari Booking #{$booking->id} - {$booking->user->name}",
                'booking_id' => $booking->id,
                'user_id' => Auth::id(), // Who completed it (Admin usually)
                'date' => now(),
            ]);

            // Create History Log
            TransactionHistory::create([
                'transaction_id' => $transaction->id,
                'user_id' => Auth::id(),
                'action' => 'created',
                'changes' => ['info' => 'Automated creation from completed booking'],
            ]);
        }
    }
}
