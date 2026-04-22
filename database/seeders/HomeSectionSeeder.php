<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    public function run(): void
    {
        HomeSection::updateOrCreate(
            ['section_key' => 'hero'],
            [
                'title' => [
                    'fr' => 'Nous concevons votre portfolio de référence',
                    'ar' => 'نصمم موقع البورتفوليو الذي يمثل علامتك',
                    'en' => 'We design the portfolio your brand deserves',
                ],
                'subtitle' => [
                    'fr' => 'Design, contenu, SEO et performance.',
                    'ar' => 'تصميم، محتوى، تحسين محركات البحث والأداء.',
                    'en' => 'Design, content, SEO, and performance.',
                ],
                'content' => [
                    'fr' => 'Publiez vos projets en quelques clics depuis l’admin.',
                    'ar' => 'انشر مشاريعك بسهولة من لوحة الإدارة.',
                    'en' => 'Publish and manage portfolio content directly from admin.',
                ],
                'image' => 'home/hero.jpg',
                'cta_label' => ['fr' => 'Voir nos projets', 'ar' => 'شاهد المشاريع', 'en' => 'View projects'],
                'cta_link' => '/projects',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
    }
}
