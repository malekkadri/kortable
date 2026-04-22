<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'status' => 'published',
                'is_active' => true,
                'template' => 'home',
                'sort_order' => 1,
                'slug_translations' => [
                    'fr' => 'accueil',
                    'ar' => 'home',
                    'en' => 'home',
                ],
                'title' => [
                    'fr' => 'Accueil',
                    'ar' => 'الرئيسية',
                    'en' => 'Home',
                ],
                'excerpt' => [
                    'fr' => 'Agence digitale pour portfolios modernes et rapides.',
                    'ar' => 'وكالة رقمية لبناء بورتفوليو عصري وسريع.',
                    'en' => 'Digital studio building modern, high-performance portfolios.',
                ],
                'content' => [
                    'fr' => "Nous transformons les idées en expériences web mesurables.",
                    'ar' => 'نحوّل الأفكار إلى تجارب ويب قابلة للقياس.',
                    'en' => 'We turn ideas into measurable web experiences.',
                ],
                'body' => [
                    'fr' => "Nous transformons les idées en expériences web mesurables.",
                    'ar' => 'نحوّل الأفكار إلى تجارب ويب قابلة للقياس.',
                    'en' => 'We turn ideas into measurable web experiences.',
                ],
                'featured_image' => 'pages/home-cover.jpg',
                'seo' => [
                    'meta_title' => [
                        'fr' => 'Accueil | Kortable',
                        'ar' => 'الرئيسية | كورتابل',
                        'en' => 'Home | Kortable',
                    ],
                    'meta_description' => [
                        'fr' => 'Créez un portfolio multilingue qui attire des clients.',
                        'ar' => 'أنشئ موقع بورتفوليو متعدد اللغات يجذب العملاء.',
                        'en' => 'Build a multilingual portfolio that wins clients.',
                    ],
                ],
                'published_at' => now(),
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'status' => 'published',
                'is_active' => true,
                'template' => 'default',
                'sort_order' => 2,
                'slug_translations' => [
                    'fr' => 'a-propos',
                    'ar' => 'about',
                    'en' => 'about',
                ],
                'title' => [
                    'fr' => 'À propos',
                    'ar' => 'من نحن',
                    'en' => 'About',
                ],
                'excerpt' => [
                    'fr' => 'Une équipe produit, design et contenu sous le même toit.',
                    'ar' => 'فريق يجمع التصميم والتطوير وصناعة المحتوى.',
                    'en' => 'A team combining product, design, and content expertise.',
                ],
                'content' => [
                    'fr' => 'Kortable aide les freelances et studios à valoriser leurs projets.',
                    'ar' => 'يساعد كورتابل المستقلين والاستوديوهات على إبراز أعمالهم.',
                    'en' => 'Kortable helps freelancers and studios showcase work with impact.',
                ],
                'body' => [
                    'fr' => 'Kortable aide les freelances et studios à valoriser leurs projets.',
                    'ar' => 'يساعد كورتابل المستقلين والاستوديوهات على إبراز أعمالهم.',
                    'en' => 'Kortable helps freelancers and studios showcase work with impact.',
                ],
                'seo' => [
                    'meta_title' => ['fr' => 'À propos | Kortable', 'ar' => 'من نحن | كورتابل', 'en' => 'About | Kortable'],
                ],
                'published_at' => now(),
            ]
        );
    }
}
