<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        ProjectCategory::updateOrCreate(
            ['slug' => 'branding'],
            [
                'name' => ['fr' => 'Branding', 'ar' => 'الهوية البصرية', 'en' => 'Branding'],
                'description' => [
                    'fr' => 'Identité visuelle, storytelling et guidelines.',
                    'ar' => 'هوية بصرية، سرد قصصي، ودليل استخدام.',
                    'en' => 'Visual identity, storytelling, and brand guidelines.',
                ],
                'is_active' => true,
            ]
        );

        ProjectCategory::updateOrCreate(
            ['slug' => 'web-development'],
            [
                'name' => ['fr' => 'Développement Web', 'ar' => 'تطوير الويب', 'en' => 'Web Development'],
                'description' => [
                    'fr' => 'Sites Laravel, headless CMS et dashboards.',
                    'ar' => 'مواقع لارافيل ولوحات تحكم مخصصة.',
                    'en' => 'Laravel websites, headless CMS, and dashboards.',
                ],
                'is_active' => true,
            ]
        );
    }
}
