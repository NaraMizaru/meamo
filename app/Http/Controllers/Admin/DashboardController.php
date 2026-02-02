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
            // 2. Find the strictly next 'booked' booking (Today or Future)
            $next_booking = Booking::with(['user', 'service', 'schedule', 'items', 'addons'])
                ->where('bookings.status', 'booked')
                ->join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
                ->whereDate('schedules.event_date', '>=', now())
                ->orderBy('schedules.event_date', 'asc')
                ->orderBy('schedules.start_time', 'asc')
                ->orderBy('bookings.sequence', 'asc')
                ->select('bookings.*')
                ->first();

            // Calculate current schedule ONLY for "Empty State" context if needed
            $now = now();
            $currentSchedule = \App\Models\Schedule::where('event_date', today())
                ->where('start_time', '<=', $now->format('H:i:s'))
                ->where('end_time', '>=', $now->format('H:i:s'))
                ->first();
        }


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
