<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'service_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(ServiceAddon::class, 'service_service_addon', 'service_id', 'service_addon_id')
            ->withTimestamps();
    }
}
