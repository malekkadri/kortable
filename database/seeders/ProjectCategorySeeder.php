<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'branding',
                'sort_order' => 1,
                'name' => ['fr' => 'Branding', 'ar' => 'الهوية البصرية', 'en' => 'Branding'],
                'description' => [
                    'fr' => 'Identité visuelle, storytelling et guidelines.',
                    'ar' => 'هوية بصرية، سرد قصصي، ودليل استخدام.',
                    'en' => 'Visual identity, storytelling, and brand guidelines.',
                ],
            ],
            [
                'slug' => 'web-development',
                'sort_order' => 2,
                'name' => ['fr' => 'Développement Web', 'ar' => 'تطوير الويب', 'en' => 'Web Development'],
                'description' => [
                    'fr' => 'Sites Laravel, headless CMS et dashboards.',
                    'ar' => 'مواقع لارافيل ولوحات تحكم مخصصة.',
                    'en' => 'Laravel websites, headless CMS, and dashboards.',
                ],
            ],
            [
                'slug' => 'ecommerce',
                'sort_order' => 3,
                'name' => ['fr' => 'E-commerce', 'ar' => 'التجارة الإلكترونية', 'en' => 'E-commerce'],
                'description' => [
                    'fr' => 'Boutiques en ligne et optimisation du tunnel de conversion.',
                    'ar' => 'متاجر رقمية وتحسين مسار الشراء.',
                    'en' => 'Online stores and conversion funnel optimization.',
                ],
            ],
        ];

        foreach ($categories as $category) {
            ProjectCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category + ['is_active' => true]
            );
        }
    }
}
