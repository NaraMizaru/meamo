<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'booked' => Booking::where('status', 'booked')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        // Find the "Next Booking" (nearest future booked item)
        // Checks Schedule date + booking sequence
        // We join with schedules to curb date ordering correctly if needed, but Booking has schedule_id.
        // Easiest is to order by schedule's event_date then booking sequence.

        // 1. Check for any Processing booking first (Top Priority)
        // Processing booking is assumed to be "Now" regardless of schedule time (admin started it).
        $processingBooking = Booking::with(['user', 'service', 'schedule', 'items', 'addons'])
            ->where('status', 'processing')
            ->first();

        $next_booking = null;
        $currentSchedule = null;

        if ($processingBooking) {
            $next_booking = $processingBooking;
        } else {
            // 2. Find strictly Active Schedule (Today + Now inside Start/End)
            $now = now();
            $currentSchedule = \App\Models\Schedule::where('event_date', today())
                ->where('start_time', '<=', $now->format('H:i:s'))
                ->where('end_time', '>=', $now->format('H:i:s'))
                ->first();

            if ($currentSchedule) {
                // 3. Find next 'booked' in this specific schedule
                $next_booking = Booking::with(['user', 'service', 'schedule', 'items', 'addons'])
                    ->where('schedule_id', $currentSchedule->id)
                    ->where('status', 'booked')
                    ->orderBy('sequence', 'asc')
                    ->first();
            }
        }

        // Upcoming Queue (Next 6 generally, or next 6 in session? Let's keep general for visibility or restrict?)
        // User request: "tampilan jadwal sekarang sudah kosong" -> implies looking at *current*.
        // But "queue" usually means looking ahead.
        // Let's keep Queue as "Global Upcoming" but excluding the one currently shown.
        // Or should Queue also be restricted?
        // "jika di schedule sekarang sudah tidak ada lagi... tampilan jadwal ... kosong"
        // This refers to the "Next Booking" card area.
        // Let's keep Upcoming Queue as "What's coming up" (could be next session).

        $upcoming_query = Booking::with(['user', 'service', 'schedule'])
            ->whereIn('bookings.status', ['booked', 'processing']) // Just in case
            ->join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
            ->where(function ($q) {
                $q->where('schedules.event_date', '>', today())
                    ->orWhere(function ($sub) {
                        $sub->where('schedules.event_date', today())
                            ->where('schedules.end_time', '>=', now()->format('H:i:s'));
                    });
            })
            ->orderBy('schedules.event_date', 'asc')
            ->orderBy('bookings.sequence', 'asc')
            ->select('bookings.*');

        if ($next_booking) {
            $upcoming_query->where('bookings.id', '!=', $next_booking->id);
        }

        $upcoming_queue = $upcoming_query->take(6)->get();

        return view('admin.dashboard', compact('stats', 'next_booking', 'upcoming_queue', 'currentSchedule'));
    }
}
