<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceAddon;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Items
        $strip = Item::where('name', 'Photo Strip')->firstOrFail();
        $keychain = Item::where('name', 'Keychain')->firstOrFail();
        $koran = Item::where('name', 'Koran A4')->firstOrFail();

        // 1. Reguler Service
        $reguler = Service::updateOrCreate(
            ['name' => 'Reguler'],
            ['price' => 15000, 'description' => '2 Strip Photo']
        );
        $reguler->items()->sync([$strip->id => ['quantity' => 2]]);

        // 2. Couple Service
        $couple = Service::updateOrCreate(
            ['name' => 'Couple'],
            ['price' => 35000, 'description' => '2 Strip Photo, 2 Keychain']
        );
        $couple->items()->sync([
            $strip->id => ['quantity' => 2],
            $keychain->id => ['quantity' => 2],
        ]);

        // 3. Bigframe Service
        $bigframe = Service::updateOrCreate(
            ['name' => 'Bigframe'],
            ['price' => 25000, 'description' => '1 Koran A4']
        );
        $bigframe->items()->sync([$koran->id => ['quantity' => 1]]);

        // --- Addons ---

        // Extra 2 Strips
        $extraStrips = ServiceAddon::updateOrCreate(
            ['name' => 'Extra 2 Strips'],
            ['price' => 10000, 'description' => 'Add 2 Photo Strips']
        );
        $extraStrips->items()->sync([$strip->id => ['quantity' => 2]]);

        // Extra Keychain
        $extraKeychain = ServiceAddon::updateOrCreate(
            ['name' => 'Extra Keychain'],
            ['price' => 10000, 'description' => 'Add 1 Keychain']
        );
        $extraKeychain->items()->sync([$keychain->id => ['quantity' => 1]]);

        // Couple Combo
        $coupleCombo = ServiceAddon::updateOrCreate(
            ['name' => 'Couple Combo'],
            ['price' => 15000, 'description' => '1 Strip Photo + 1 Keychain']
        );
        $coupleCombo->items()->sync([
            $strip->id => ['quantity' => 1],
            $keychain->id => ['quantity' => 1],
        ]);

        // Extra Koran
        $extraKoran = ServiceAddon::updateOrCreate(
            ['name' => 'Extra Koran'],
            ['price' => 20000, 'description' => 'Add 1 Koran A4']
        );
        $extraKoran->items()->sync([$koran->id => ['quantity' => 1]]);

        // --- Link Addons to Services ---

        // Reguler can add Strips, Keychain.
        $reguler->addons()->syncWithoutDetaching([$extraStrips->id, $extraKeychain->id]);

        // Couple can add Strips, Keychain, Couple Combo.
        $couple->addons()->syncWithoutDetaching([$extraStrips->id, $extraKeychain->id, $coupleCombo->id]);

        // Bigframe can add Extra Koran.
        $bigframe->addons()->syncWithoutDetaching([$extraKoran->id]);
    }
}
