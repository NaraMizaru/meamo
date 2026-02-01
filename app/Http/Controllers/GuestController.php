<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

class GuestController extends Controller
{
    public function checkQueue()
    {
        return view('guest.check-queue');
    }

    public function searchQueue(Request $request)
    {
        $request->validate([
            'type' => 'required|in:phone,queue',
            'query' => 'required|string',
        ]);

        $query = $request->input('query');
        $type = $request->input('type');

        $booking = null;

        if ($type === 'queue') {
            // Check by Queue Number
            $booking = Booking::with(['user', 'service', 'schedule', 'items', 'addons', 'promo'])
                ->where('queue_number', $query)
                ->first();
        } else {
            // Check by Phone Number
            // Normalize phone? Assuming user inputs mostly correct
            // Find User first?
            // "data dengan schedule yang paling mendekati waktu sekarang"

            // Allow partial phone match or exact? Usually exact for privacy.
            $bookings = Booking::with(['user', 'service', 'schedule', 'items', 'addons', 'promo'])
                ->whereHas('user', function ($q) use ($query) {
                    $q->where('phone_number', $query)
                        ->orWhere('phone_number', 'like', "%{$query}") // relaxed check?
                        ->orWhere('phone_number', '0' . ltrim($query, '+62'));
                })
                ->whereHas('schedule', function ($q) {
                    $q->where('event_date', '>=', now()->startOfDay());
                })
                ->whereIn('status', ['booked', 'processing']) // Active only? "data ... schedule paling mendekati" implied future/active
                ->join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
                ->orderBy('schedules.event_date', 'asc')
                ->select('bookings.*')
                ->get();

            // Closest to now? 
            // The query sorts by date ASC. The first one is the "Next/Closest".
            $booking = $bookings->first();
        }

        if (!$booking) {
            return back()->with('error', 'Booking tidak ditemukan.')->withInput();
        }

        return view('guest.check-queue', compact('booking'));
    }
}
