<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ItemSeeder::class,
            ServiceSeeder::class,
            ScheduleSeeder::class,
            SettingSeeder::class,
            PromoSeeder::class,
        ]);
    }
}
