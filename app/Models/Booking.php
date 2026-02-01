<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'schedule_id',
        'promo_id',
        'queue_number',
        'sequence',
        'status',
        'notes',
        'total_price',
        'processing_started_at',
    ];

    protected $casts = [
        'processing_started_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'booking_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(ServiceAddon::class, 'booking_addons')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isBooked(): bool
    {
        return $this->status === 'booked';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isSkipped(): bool
    {
        return $this->status === 'skipped';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function getEstimatedStartTimeAttribute()
    {
        if (!$this->schedule) {
            return now();
        }

        $baseTime = \Carbon\Carbon::parse($this->schedule->event_date->format('Y-m-d') . ' ' . $this->schedule->start_time);

        $preceding = Booking::where('schedule_id', $this->schedule_id)
            ->where('sequence', '<', $this->sequence)
            ->where('status', '!=', 'cancelled')
            ->orderBy('sequence')
            ->get();

        $duration = (int) \App\Models\Setting::getValue('booking_duration_minutes', 5);
        $currentTime = $baseTime->copy();

        foreach ($preceding as $prev) {
            if ($prev->status === 'completed') {
                $completedAt = $prev->updated_at;
                if ($completedAt->gt($currentTime)) {
                    $currentTime = $completedAt->copy();
                }
            } else {
                $currentTime->addMinutes($duration);
            }
        }

        return $currentTime;
    }

    public function getTimeSlotAttribute(): string
    {
        if (!$this->schedule) {
            return '-';
        }

        $startTime = $this->estimated_start_time;
        $duration = (int) \App\Models\Setting::getValue('booking_duration_minutes', 5);
        $endTime = $startTime->copy()->addMinutes($duration);

        return $startTime->format('H:i') . ' - ' . $endTime->format('H:i');
    }
}
