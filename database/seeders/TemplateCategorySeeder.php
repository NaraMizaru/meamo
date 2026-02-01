<?php

namespace Database\Seeders;

use App\Models\TemplateCategory;
use Illuminate\Database\Seeder;

class TemplateCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Birthday',
            'Wedding',
            'Anniversary',
            'Graduation',
            'Valentine',
            'Christmas',
            'New Year',
            'Eid Mubarak',
            'Family',
            'Friendship',
            'Baby Shower',
            'Engagement',
        ];

        foreach ($categories as $category) {
            TemplateCategory::firstOrCreate(['name' => $category]);
        }
    }
}
