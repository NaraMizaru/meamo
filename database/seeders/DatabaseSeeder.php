<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            ServiceSeeder::class,
            ScheduleSeeder::class,
            SettingSeeder::class,
            PromoSeeder::class,
            TemplateCategorySeeder::class,
            TemplateSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
