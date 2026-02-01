<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceAddon;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $services = Service::all();
        $schedules = Schedule::where('status', 'available')->get();

        if ($users->isEmpty() || $services->isEmpty() || $schedules->isEmpty()) {
            return;
        }

        $statuses = ['booked', 'completed', 'skipped', 'cancelled'];
        $notes = [
            'Untuk ulang tahun anak saya',
            'Foto keluarga besar',
            'Anniversary wedding',
            'Graduation photo',
            'Pre-wedding session',
            'Baby shower event',
            'Company gathering',
            'Birthday surprise',
            null,
            null,
        ];

        $bookingData = [];
        $sequence = 1;

        // Generate bookings for each schedule
        foreach ($schedules as $schedule) {
            // Random 2-5 bookings per schedule
            $bookingsCount = rand(2, 5);
            $scheduleSequence = 1;

            for ($i = 0; $i < $bookingsCount; $i++) {
                $user = $users->random();
                $service = $services->random();
                $status = $statuses[array_rand($statuses)];

                // Calculate total price
                $totalPrice = $service->price;

                $booking = Booking::create([
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'schedule_id' => $schedule->id,
                    'promo_id' => null,
                    'queue_number' => 'Q' . str_pad($sequence, 4, '0', STR_PAD_LEFT),
                    'sequence' => $scheduleSequence,
                    'status' => $status,
                    'notes' => $notes[array_rand($notes)],
                    'total_price' => $totalPrice,
                ]);

                // Sync items from service
                $itemsSync = [];
                foreach ($service->items as $item) {
                    $itemsSync[$item->id] = ['quantity' => $item->pivot->quantity];
                }
                $booking->items()->sync($itemsSync);

                // Random chance to add addons (50%)
                if (rand(0, 1) === 1) {
                    $serviceAddons = $service->addons;
                    if ($serviceAddons->count() > 0) {
                        $addon = $serviceAddons->random();
                        $addonQty = rand(1, 3);
                        $booking->addons()->attach($addon->id, [
                            'quantity' => $addonQty,
                            'price' => $addon->price,
                        ]);
                        $booking->total_price += ($addon->price * $addonQty);
                        $booking->save();
                    }
                }

                $sequence++;
                $scheduleSequence++;
            }
        }
    }
}
