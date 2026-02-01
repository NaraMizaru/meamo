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
        $couple = Service::where('name', 'Couple')->first();
        $bigframe = Service::where('name', 'Bigframe')->first();

        // Auto Promo for Reguler: 2k off
        if ($reguler) {
            Promo::create([
                'code' => null,
                'is_auto' => true,
                'service_id' => $reguler->id,
                'discount_amount' => 2000,
                'start_date' => '2026-02-02 00:00:00',
                'end_date' => '2026-02-04 23:59:59',
                'description' => 'Promo Reguler 2K Off',
            ]);
        }

        // Auto Promo for Couple: 5k off Valentine
        if ($couple) {
            Promo::create([
                'code' => null,
                'is_auto' => true,
                'service_id' => $couple->id,
                'discount_amount' => 5000,
                'start_date' => '2026-02-14 00:00:00',
                'end_date' => '2026-02-14 23:59:59',
                'description' => 'Valentine Special - Couple 5K Off',
            ]);
        }

        // Weekend Promo for Bigframe
        if ($bigframe) {
            Promo::create([
                'code' => null,
                'is_auto' => true,
                'service_id' => $bigframe->id,
                'discount_amount' => 3000,
                'start_date' => '2026-02-07 00:00:00',
                'end_date' => '2026-02-08 23:59:59',
                'description' => 'Weekend Promo Bigframe 3K Off',
            ]);
        }

        // Code-based Promos
        if ($reguler) {
            Promo::create([
                'code' => 'HEMAT10',
                'is_auto' => false,
                'service_id' => $reguler->id,
                'discount_amount' => 10000,
                'start_date' => '2026-02-01 00:00:00',
                'end_date' => '2026-02-28 23:59:59',
                'description' => 'Diskon 10K untuk Reguler dengan kode HEMAT10',
            ]);
        }

        if ($couple) {
            Promo::create([
                'code' => 'COUPLE20',
                'is_auto' => false,
                'service_id' => $couple->id,
                'discount_amount' => 20000,
                'start_date' => '2026-02-01 00:00:00',
                'end_date' => '2026-03-31 23:59:59',
                'description' => 'Diskon 20K untuk Couple dengan kode COUPLE20',
            ]);
        }

        if ($bigframe) {
            Promo::create([
                'code' => 'BIGFRAME15',
                'is_auto' => false,
                'service_id' => $bigframe->id,
                'discount_amount' => 15000,
                'start_date' => '2026-02-01 00:00:00',
                'end_date' => '2026-04-30 23:59:59',
                'description' => 'Diskon 15K untuk Bigframe dengan kode BIGFRAME15',
            ]);
        }

        // Universal promo (all services)
        Promo::create([
            'code' => 'NEWUSER',
            'is_auto' => false,
            'service_id' => null,
            'discount_amount' => 5000,
            'start_date' => '2026-01-01 00:00:00',
            'end_date' => '2026-12-31 23:59:59',
            'description' => 'Diskon 5K untuk user baru - Semua layanan',
        ]);

        Promo::create([
            'code' => 'FLASH25',
            'is_auto' => false,
            'service_id' => null,
            'discount_amount' => 25000,
            'start_date' => '2026-02-15 00:00:00',
            'end_date' => '2026-02-15 23:59:59',
            'description' => 'Flash Sale 25K - 1 Hari Saja!',
        ]);
    }
}
