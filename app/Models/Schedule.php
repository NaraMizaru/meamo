<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = [
        'event_date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable(): bool
    {
        // Calculate max capacity based on dynamic slot duration
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);

        $duration = (int) \App\Services\SettingsService::get('booking_duration_minutes', 5);

        // Use abs to ensure positive duration
        $durationInMinutes = abs($end->diffInMinutes($start));
        $maxCapacity = floor($durationInMinutes / $duration);

        // Count active bookings (excluding cancelled)
        $currentBookings = $this->bookings()->where('status', '!=', 'cancelled')->count();

        return $currentBookings < $maxCapacity;
    }

    public function getNextSlotAttribute(): string
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $currentBookings = $this->bookings()->where('status', '!=', 'cancelled')->count();
        $duration = (int) \App\Services\SettingsService::get('booking_duration_minutes', 5);

        $slotStart = $start->addMinutes($currentBookings * $duration);
        $slotEnd = $slotStart->copy()->addMinutes($duration);

        return $slotStart->format('H:i') . ' - ' . $slotEnd->format('H:i');
    }
}
