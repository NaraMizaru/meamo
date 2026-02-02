<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // My Next Booking (Nearest Future)
        $query = $user->bookings()->with(['service', 'schedule', 'items', 'addons', 'promo'])
            ->where('bookings.status', 'booked')
            ->whereHas('schedule', function ($q) {
                $q->where('event_date', '>=', now()->startOfDay());
            })

            ->join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
            ->orderBy('schedules.event_date', 'asc')
            ->orderBy('bookings.sequence', 'asc')
            ->select('bookings.*');

        $next_booking = (clone $query)->first();

        // My Upcoming Queue (Next 6)
        $upcoming_queue = [];
        if ($next_booking) {
            $upcoming_queue = (clone $query)->where('bookings.id', '!=', $next_booking->id)->take(6)->get();
        } else {
            $upcoming_queue = (clone $query)->take(6)->get();
        }

        return view('user.dashboard', compact('next_booking', 'upcoming_queue'));
    }
}
