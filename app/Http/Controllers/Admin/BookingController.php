<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'service', 'schedule']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'service', 'schedule']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,booked,completed,cancelled',
        ]);

        $booking->update($validated);

        if ($validated['status'] === 'booked') {
            // $booking->schedule->update(['status' => 'booked']);
            // Logic change: Schedule remains available until full capacity (handled in booking creation)
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Status booking berhasil diupdate!');
    }

    public function sendResult(Booking $booking)
    {
        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Hasil foto berhasil dikirim ke customer!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus!');
    }

    public function moveToTop(Booking $booking)
    {
        if ($booking->status !== 'skipped') {
            return back()->with('error', 'Only skipped bookings can be moved to top.');
        }

        $queueService = new \App\Services\QueueService();
        $queueService->insertSkippedBooking($booking);

        return back()->with('success', 'Booking moved to top of the queue!');
    }
}
