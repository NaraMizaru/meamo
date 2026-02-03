<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitializeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
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
