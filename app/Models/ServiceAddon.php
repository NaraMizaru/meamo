<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServiceAddon extends Model
{
    protected $fillable = ['name', 'price', 'description'];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_service_addon', 'service_addon_id', 'service_id')
            ->withTimestamps();
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'addon_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
