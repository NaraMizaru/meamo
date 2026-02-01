<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Photo Strip',
            'Keychain',
            'Koran A4',
        ];

        foreach ($items as $name) {
            Item::firstOrCreate(['name' => $name]);
        }
    }
}
