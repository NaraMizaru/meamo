<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class QueueService
{
    /**
     * Generate next queue number for the day.
     * Format: YYYYMMDD-{SEQ}
     */
    public function generateQueueNumber(Carbon $date): string
    {
        $dateStr = $date->format('Ymd');

        $lastBooking = Booking::where('queue_number', 'like', "{$dateStr}-%")
            ->orderByRaw('LENGTH(queue_number) DESC')
            ->orderBy('queue_number', 'desc')
            ->first();

        $seq = 1;
        if ($lastBooking) {
            $parts = explode('-', $lastBooking->queue_number);
            if (isset($parts[1])) {
                $seq = intval($parts[1]) + 1;
            }
        }

        return "{$dateStr}-{$seq}";
    }

    /**
     * Get estimated start time for a booking.
     */
    public function getEstimatedStartTime(Booking $booking): Carbon
    {
        $schedule = $booking->schedule;
        if (!$schedule) {
            return now();
        }

        $baseTime = Carbon::parse($schedule->event_date->format('Y-m-d') . ' ' . $schedule->start_time);

        // Get all preceding bookings in this schedule ordered by sequence
        // Exclude cancelled.
        $preceding = Booking::where('schedule_id', $schedule->id)
            ->where('sequence', '<', $booking->sequence)
            ->where('status', '!=', 'cancelled')
            ->orderBy('sequence')
            ->get();

        $duration = (int) SettingsService::get('booking_duration_minutes', 5);

        $currentTime = $baseTime->copy();

        foreach ($preceding as $prev) {
            if ($prev->status === 'completed') {
                $completedAt = $prev->updated_at; // Assuming updated_at is completion time.
                if ($completedAt->gt($currentTime)) {
                    $currentTime = $completedAt->copy();
                }
            } else {
                // Pending/Skipped/Booked - Adds theoretical duration.
                $currentTime->addMinutes($duration);
            }
        }

        return $currentTime;
    }

    /**
     * Re-insert a skipped booking to the "now" position (after current processing).
     */
    public function insertSkippedBooking(Booking $skippedBooking)
    {
        return DB::transaction(function () use ($skippedBooking) {
            $scheduleId = $skippedBooking->schedule_id;

            $nextBooking = Booking::where('schedule_id', $scheduleId)
                ->whereIn('status', ['booked', 'processing']) // Changed from pending
                ->orderBy('sequence')
                ->first();

            if (!$nextBooking) {
                $skippedBooking->update(['status' => 'booked']);
                return;
            }

            // Shift everything from nextBooking->sequence onwards by +1
            Booking::where('schedule_id', $scheduleId)
                ->where('sequence', '>=', $nextBooking->sequence)
                ->where('id', '!=', $skippedBooking->id) // Safety
                ->increment('sequence');

            // Set skipped booking to nextBooking's original sequence
            $skippedBooking->update([
                'sequence' => $nextBooking->sequence,
                'status' => 'booked' // Changed from pending
            ]);
        });
    }

    /**
     * Assign sequence to new booking.
     */
    public function assignSequence(Booking $booking)
    {
        $maxSeq = Booking::where('schedule_id', $booking->schedule_id)->max('sequence');
        $booking->update(['sequence' => $maxSeq + 1]);
    }
}
