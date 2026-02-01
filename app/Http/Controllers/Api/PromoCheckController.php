<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\PromoService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromoCheckController extends Controller
{
    protected $promoService;

    public function __construct(PromoService $promoService)
    {
        $this->promoService = $promoService;
    }

    /**
     * Check for promo (manual or auto) validity.
     */
    public function check(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'code' => 'nullable|string',
        ]);

        $service = Service::find($validated['service_id']);
        $date = Carbon::parse($validated['date']);
        $code = $validated['code'] ?? null;

        $promo = null;

        // 1. Manual Code Check
        if ($code) {
            $promo = $this->promoService->validateCode($code, $service, $date);
        } else {
            // 2. Auto Check (Find best applicable auto promo)
            $promos = $this->promoService->getApplicablePromos($service, $date);
            if ($promos->isNotEmpty()) {
                $promo = $promos->first();
            }
        }

        if ($promo) {
            return response()->json([
                'valid' => true,
                'promo' => [
                    'id' => $promo->id,
                    'code' => $promo->code,
                    'discount_amount' => $promo->discount_amount,
                    'discount_percentage' => $promo->discount_percentage,
                ]
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => $code ? 'Promo code invalid or expired.' : 'No auto promo available.'
        ]);
    }
}
