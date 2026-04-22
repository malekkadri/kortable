<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['slug' => 'portfolio-design', 'title' => ['fr' => 'Design Portfolio', 'ar' => 'تصميم البورتفوليو', 'en' => 'Portfolio Design']],
            ['slug' => 'web-development', 'title' => ['fr' => 'Développement Web', 'ar' => 'تطوير الويب', 'en' => 'Web Development']],
            ['slug' => 'seo-content', 'title' => ['fr' => 'SEO & Contenu', 'ar' => 'تحسين محركات البحث والمحتوى', 'en' => 'SEO & Content']],
        ];

        foreach ($services as $index => $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                [
                    'title' => $service['title'],
                    'short_description' => ['fr' => 'Offre premium pour studios et freelances.', 'ar' => 'خدمة احترافية للاستوديوهات والمستقلين.', 'en' => 'Premium offer for studios and freelancers.'],
                    'description' => ['fr' => 'Livraison rapide, qualité élevée, support continu.', 'ar' => 'تسليم سريع وجودة عالية ودعم مستمر.', 'en' => 'Fast delivery, high quality, ongoing support.'],
                    'icon' => 'icon-star',
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
