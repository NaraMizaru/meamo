<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::with('addons')->get();

        $schedules = Schedule::whereIn('status', ['available', 'booked'])
            ->where('event_date', '>=', today())
            ->orderBy('event_date')
            ->get();

        return view('user.booking', compact('services', 'schedules'));
    }

    public function store(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (!$user->phone_number) {
            return redirect()->route('profile.edit')
                ->with('error', 'Silahkan lengkapi nomor HP Anda sebelum melakukan booking.');
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'schedule_id' => 'required|exists:schedules,id',
            'addons' => 'nullable|array',
            'addons.*' => 'integer|min:0', // Key is ID, Value is Quantity
            'promo_code' => 'nullable|string|exists:promos,code',
            'notes' => 'nullable|string',
        ]);

        $schedule = Schedule::find($validated['schedule_id']);

        if (!$schedule->isAvailable()) {
            return back()->with('error', 'Jadwal yang dipilih sudah penuh (Full Booked)!');
        }

        // --- Price Calculation ---
        $service = Service::with('items')->find($validated['service_id']);
        $totalPrice = $service->price;
        $bookingItems = []; // itemId => quantity

        // Add Service Items
        foreach ($service->items as $item) {
            $bookingItems[$item->id] = ($bookingItems[$item->id] ?? 0) + $item->pivot->quantity;
        }

        // Addons
        $addonData = [];
        if (!empty($validated['addons'])) {
            // Filter addons with quantity > 0
            $selectedAddonIds = array_keys(array_filter($validated['addons'], fn($q) => $q > 0));

            if (!empty($selectedAddonIds)) {
                $addons = \App\Models\ServiceAddon::with('items')->findMany($selectedAddonIds);
                foreach ($addons as $addon) {
                    $qty = (int) $validated['addons'][$addon->id];
                    if ($qty > 0) {
                        $totalPrice += ($addon->price * $qty);
                        $addonData[$addon->id] = ['quantity' => $qty, 'price' => $addon->price];

                        foreach ($addon->items as $item) {
                            $itemQty = $item->pivot->quantity;
                            // Multiply item yield by addon quantity
                            $bookingItems[$item->id] = ($bookingItems[$item->id] ?? 0) + ($itemQty * $qty);
                        }
                    }
                }
            }
        }

        // Promo
        $promoId = null;
        if (!empty($validated['promo_code'])) {
            $promoService = new \App\Services\PromoService();
            // Validate based on Schedule Date
            $promo = $promoService->validateCode($validated['promo_code'], $service, $schedule->event_date);
            if ($promo) {
                $discount = $promoService->calculateDiscount($promo, $totalPrice);
                $totalPrice -= $discount;
                $promoId = $promo->id;

                // Increment promo usage
                $promo->increment('used_count');
            }
        }
        // Auto apply promo logic could go here if no code provided

        $queueService = new \App\Services\QueueService();
        $queueNumber = $queueService->generateQueueNumber($schedule->event_date);

        $booking = Booking::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'schedule_id' => $schedule->id,
            'promo_id' => $promoId,
            'queue_number' => $queueNumber,
            'status' => 'pending',
            'total_price' => max(0, $totalPrice),
            'notes' => $validated['notes'] ?? null,
            'sequence' => 0, // Will update below
        ]);

        $queueService->assignSequence($booking);

        // Attach Relationships
        if (!empty($addonData)) {
            $booking->addons()->attach($addonData);
        }

        // Attach Items Snapshot
        foreach ($bookingItems as $itemId => $qty) {
            $booking->items()->attach($itemId, ['quantity' => $qty]);
        }

        return redirect()->route('dashboard')
            ->with('success', "Booking berhasil! Nomor Antrian Anda: {$queueNumber}");
    }
}
