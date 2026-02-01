<?php

namespace Database\Seeders;

use App\Models\Promo;
use App\Models\Service;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $reguler = Service::where('name', 'Reguler')->first();

        // Default Auto Promo for Reguler: 2k off, Feb 2-4
        if ($reguler) {
            Promo::create([
                'code' => null, // Auto promo
                'is_auto' => true,
                'service_id' => $reguler->id,
                'discount_amount' => 2000,
                'start_date' => '2026-02-02 00:00:00',
                'end_date' => '2026-02-04 23:59:59',
                'description' => 'Default Promo Reguler 2k Off',
            ]);
        }
    }
}
