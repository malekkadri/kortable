<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $category = ProjectCategory::where('slug', 'web-development')->first();

        Project::updateOrCreate(
            ['slug' => 'atelier-nova-portfolio'],
            [
                'category_id' => $category?->id,
                'title' => [
                    'fr' => 'Portfolio Atelier Nova',
                    'ar' => 'بورتفوليو أتيليه نوفا',
                    'en' => 'Atelier Nova Portfolio',
                ],
                'short_description' => [
                    'fr' => 'Refonte portfolio B2B orientée conversion.',
                    'ar' => 'إعادة تصميم بورتفوليو B2B مع تركيز على التحويل.',
                    'en' => 'B2B portfolio redesign optimized for conversion.',
                ],
                'description' => [
                    'fr' => 'Architecture éditoriale multilingue avec CMS sur-mesure.',
                    'ar' => 'بنية محتوى متعددة اللغات مع نظام إدارة مخصص.',
                    'en' => 'Multilingual editorial architecture with custom CMS.',
                ],
                'client_name' => 'Atelier Nova',
                'project_date' => '2025-11-15',
                'website_url' => 'https://example.com/nova',
                'featured_image' => 'projects/nova/cover.jpg',
                'gallery' => ['projects/nova/1.jpg', 'projects/nova/2.jpg'],
                'technologies' => ['Laravel', 'Tailwind CSS', 'Alpine.js'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'published_at' => now()->subDays(30),
                'seo' => [
                    'meta_title' => ['fr' => 'Projet Nova', 'ar' => 'مشروع نوفا', 'en' => 'Nova Project'],
                ],
            ]
        );
    }
}
