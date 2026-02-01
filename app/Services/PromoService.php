<?php

namespace App\Services;

use App\Models\Promo;
use App\Models\Service;
use Carbon\Carbon;

class PromoService
{
    /**
     * Get applicable auto promos for a service.
     */
    public function getApplicablePromos(Service $service, Carbon $date)
    {
        return Promo::active($date)
            ->where('is_auto', true)
            ->where(function ($q) use ($service) {
                $q->whereNull('service_id')->orWhere('service_id', $service->id);
            })
            ->get();
    }

    /**
     * Validate a promo code.
     */
    public function validateCode(string $code, Service $service, Carbon $date)
    {
        $promo = Promo::active($date)
            ->where('code', $code)
            ->where(function ($q) use ($service) {
                $q->whereNull('service_id')->orWhere('service_id', $service->id);
            })
            ->first();

        if (!$promo) {
            return null; // Invalid
        }

        return $promo;
    }

    /**
     * Calculate discount amount.
     */
    public function calculateDiscount(Promo $promo, float $price)
    {
        if ($promo->discount_amount) {
            return min($price, $promo->discount_amount);
        }

        if ($promo->discount_percentage) {
            return $price * ($promo->discount_percentage / 100);
        }

        return 0;
    }
}
