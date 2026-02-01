<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\TemplateCategory;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            'Birthday' => [
                ['name' => 'Birthday Balloon', 'description' => 'Colorful balloon theme for birthday celebrations'],
                ['name' => 'Birthday Cake', 'description' => 'Classic cake design with candles'],
                ['name' => 'Birthday Party', 'description' => 'Fun party decorations and confetti'],
                ['name' => 'Kids Birthday', 'description' => 'Cartoon characters for children birthday'],
            ],
            'Wedding' => [
                ['name' => 'Elegant Wedding', 'description' => 'Classic elegant wedding frame'],
                ['name' => 'Rustic Wedding', 'description' => 'Natural rustic wedding design'],
                ['name' => 'Floral Wedding', 'description' => 'Beautiful floral arrangement frame'],
                ['name' => 'Modern Wedding', 'description' => 'Minimalist modern wedding style'],
            ],
            'Anniversary' => [
                ['name' => 'Golden Anniversary', 'description' => 'Gold themed anniversary celebration'],
                ['name' => 'Silver Anniversary', 'description' => 'Silver themed anniversary frame'],
                ['name' => 'Romantic Anniversary', 'description' => 'Hearts and roses design'],
            ],
            'Graduation' => [
                ['name' => 'Academic Cap', 'description' => 'Traditional graduation cap theme'],
                ['name' => 'Celebration Grad', 'description' => 'Joyful graduation celebration'],
                ['name' => 'Achievement', 'description' => 'Success and achievement themed'],
            ],
            'Valentine' => [
                ['name' => 'Valentine Hearts', 'description' => 'Red hearts romantic design'],
                ['name' => 'Cupid Arrow', 'description' => 'Cupid and arrow themed frame'],
                ['name' => 'Love Letter', 'description' => 'Romantic love letter style'],
            ],
            'Christmas' => [
                ['name' => 'Christmas Tree', 'description' => 'Classic Christmas tree decoration'],
                ['name' => 'Santa Claus', 'description' => 'Fun Santa Claus themed frame'],
                ['name' => 'Winter Wonderland', 'description' => 'Snowy winter scene design'],
            ],
            'New Year' => [
                ['name' => 'New Year Fireworks', 'description' => 'Colorful fireworks celebration'],
                ['name' => 'New Year Countdown', 'description' => 'Clock countdown themed frame'],
            ],
            'Eid Mubarak' => [
                ['name' => 'Eid Moon', 'description' => 'Crescent moon and stars design'],
                ['name' => 'Eid Lantern', 'description' => 'Traditional lantern themed frame'],
                ['name' => 'Eid Celebration', 'description' => 'Festive Eid celebration design'],
            ],
            'Family' => [
                ['name' => 'Family Portrait', 'description' => 'Classic family portrait frame'],
                ['name' => 'Family Gathering', 'description' => 'Warm family gathering theme'],
                ['name' => 'Family Love', 'description' => 'Heart-themed family design'],
            ],
            'Friendship' => [
                ['name' => 'Best Friends', 'description' => 'Fun best friends themed frame'],
                ['name' => 'Squad Goals', 'description' => 'Modern squad theme design'],
                ['name' => 'BFF Forever', 'description' => 'Colorful friendship celebration'],
            ],
            'Baby Shower' => [
                ['name' => 'Baby Boy', 'description' => 'Blue themed baby boy design'],
                ['name' => 'Baby Girl', 'description' => 'Pink themed baby girl design'],
                ['name' => 'Baby Animals', 'description' => 'Cute animal themed baby frame'],
            ],
            'Engagement' => [
                ['name' => 'Ring Proposal', 'description' => 'Diamond ring themed frame'],
                ['name' => 'We Said Yes', 'description' => 'Engagement celebration design'],
            ],
        ];

        foreach ($templates as $categoryName => $categoryTemplates) {
            $category = TemplateCategory::where('name', $categoryName)->first();

            if ($category) {
                foreach ($categoryTemplates as $templateData) {
                    Template::updateOrCreate(
                        [
                            'name' => $templateData['name'],
                            'template_category_id' => $category->id,
                        ],
                        [
                            'description' => $templateData['description'],
                            'status' => true,
                            'image' => 'templates/placeholder.jpg',
                        ]
                    );
                }
            }
        }
    }
}
