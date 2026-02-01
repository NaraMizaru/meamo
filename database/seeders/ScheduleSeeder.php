<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $timeSlots = [
            ['start' => '09:00:00', 'end' => '12:00:00'],
            ['start' => '10:00:00', 'end' => '14:00:00'],
            ['start' => '13:00:00', 'end' => '17:00:00'],
            ['start' => '14:00:00', 'end' => '18:00:00'],
            ['start' => '15:00:00', 'end' => '19:00:00'],
            ['start' => '16:00:00', 'end' => '20:00:00'],
            ['start' => '18:00:00', 'end' => '22:00:00'],
        ];

        $statuses = ['available', 'available', 'available', 'unavailable']; // 75% available

        // Generate schedules for the next 30 days
        for ($day = 1; $day <= 30; $day++) {
            // Random 1-3 time slots per day
            $slotsForDay = rand(1, 3);
            $usedSlots = [];

            for ($i = 0; $i < $slotsForDay; $i++) {
                // Pick a random slot that hasn't been used today
                do {
                    $slotIndex = array_rand($timeSlots);
                } while (in_array($slotIndex, $usedSlots));

                $usedSlots[] = $slotIndex;
                $slot = $timeSlots[$slotIndex];

                Schedule::create([
                    'event_date' => Carbon::now()->addDays($day),
                    'start_time' => $slot['start'],
                    'end_time' => $slot['end'],
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}
