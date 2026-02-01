<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Promo extends Model
{
    protected $fillable = [
        'code',
        'is_auto',
        'service_id',
        'discount_amount',
        'discount_percentage',
        'quota',
        'used_count',
        'start_date',
        'end_date',
        'description',
    ];

    protected $casts = [
        'is_auto' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeActive($query, $date = null)
    {
        $date = $date ? Carbon::parse($date) : now();
        return $query->where(function ($q) use ($date) {
            $q->whereNull('start_date')->orWhere('start_date', '<=', $date);
        })->where(function ($q) use ($date) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', $date);
        })->where(function ($q) {
            $q->whereNull('quota')->orWhereRaw('used_count < quota');
        });
    }
}
