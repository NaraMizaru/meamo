<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    protected $fillable = ['name'];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(ServiceAddon::class, 'addon_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
