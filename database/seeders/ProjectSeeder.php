<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProjectCategory::pluck('id', 'slug');

        $projects = [
            [
                'slug' => 'atelier-nova-portfolio',
                'category' => 'web-development',
                'client' => 'Atelier Nova',
                'date' => '2025-11-15',
                'featured' => true,
                'sort' => 1,
            ],
            [
                'slug' => 'sahara-fashion-rebrand',
                'category' => 'branding',
                'client' => 'Sahara Fashion',
                'date' => '2025-09-01',
                'featured' => true,
                'sort' => 2,
            ],
            [
                'slug' => 'greenbasket-store',
                'category' => 'ecommerce',
                'client' => 'GreenBasket',
                'date' => '2025-07-10',
                'featured' => true,
                'sort' => 3,
            ],
            [
                'slug' => 'medlink-patient-portal',
                'category' => 'web-development',
                'client' => 'MedLink Clinic',
                'date' => '2025-05-18',
                'featured' => false,
                'sort' => 4,
            ],
            [
                'slug' => 'atlas-logistics-website',
                'category' => 'web-development',
                'client' => 'Atlas Logistics',
                'date' => '2025-03-22',
                'featured' => false,
                'sort' => 5,
            ],
            [
                'slug' => 'casa-miel-brand-kit',
                'category' => 'branding',
                'client' => 'Casa Miel',
                'date' => '2025-02-05',
                'featured' => false,
                'sort' => 6,
            ],
            [
                'slug' => 'internal-brand-lab',
                'category' => 'branding',
                'client' => 'Internal R&D',
                'date' => '2026-01-12',
                'featured' => false,
                'published' => false,
                'sort' => 7,
            ],
        ];

        foreach ($projects as $item) {
            Project::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $categories[$item['category']] ?? null,
                    'title' => [
                        'fr' => ucfirst(str_replace('-', ' ', $item['slug'])).' (FR)',
                        'ar' => 'مشروع '.str_replace('-', ' ', $item['slug']),
                        'en' => ucwords(str_replace('-', ' ', $item['slug'])),
                    ],
                    'slug_translations' => [
                        'fr' => $item['slug'].'-fr',
                        'ar' => $item['slug'].'-ar',
                        'en' => $item['slug'],
                    ],
                    'short_description' => [
                        'fr' => 'Projet portfolio pour '.$item['client'].' axé performance et conversion.',
                        'ar' => 'مشروع أعمال لـ '.$item['client'].' مع تركيز على الأداء والتحويل.',
                        'en' => 'Portfolio project for '.$item['client'].' focused on performance and conversion.',
                    ],
                    'description' => [
                        'fr' => 'Analyse, design, développement et optimisation SEO sur un flux éditorial multilingue.',
                        'ar' => 'تحليل وتصميم وتطوير وتحسين SEO ضمن تدفق محتوى متعدد اللغات.',
                        'en' => 'Discovery, UX design, engineering, and SEO optimization on multilingual content workflows.',
                    ],
                    'client_name' => $item['client'],
                    'project_date' => $item['date'],
                    'website_url' => 'https://example.com/'.$item['slug'],
                    'featured_image' => null,
                    'gallery' => [],
                    'technologies' => ['Laravel', 'Tailwind CSS', 'MySQL'],
                    'is_featured' => $item['featured'],
                    'is_published' => $item['published'] ?? true,
                    'sort_order' => $item['sort'],
                    'published_at' => now()->subDays($item['sort'] * 5),
                    'seo' => [
                        'meta_title' => [
                            'fr' => 'Portfolio '.$item['client'],
                            'ar' => 'ملف أعمال '.$item['client'],
                            'en' => $item['client'].' Portfolio',
                        ],
                        'meta_description' => [
                            'fr' => 'Étude de cas '.$item['client'],
                            'ar' => 'دراسة حالة '.$item['client'],
                            'en' => 'Case study for '.$item['client'],
                        ],
                    ],
                ]
            );
        }
    }
}
