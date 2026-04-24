<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        BlogCategory::updateOrCreate(
            ['slug' => 'news'],
            [
                'name' => ['fr' => 'Actualités', 'ar' => 'الأخبار', 'en' => 'News'],
                'description' => ['fr' => 'Mises à jour de l\'entreprise', 'ar' => 'تحديثات الشركة', 'en' => 'Company updates'],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        BlogCategory::updateOrCreate(
            ['slug' => 'insights'],
            [
                'name' => ['fr' => 'Insights', 'ar' => 'تحليلات', 'en' => 'Insights'],
                'description' => ['fr' => 'Conseils et analyses', 'ar' => 'نصائح وتحليلات', 'en' => 'Tips and analysis'],
                'is_active' => true,
                'sort_order' => 2,
            ]
        );
    }
}
