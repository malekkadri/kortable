<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'section_type' => HomeSection::TYPE_HERO,
                'section_key' => 'hero',
                'title' => [
                    'fr' => 'Créez un portfolio qui vous ressemble',
                    'ar' => 'أنشئ معرض أعمال يعكس هويتك',
                    'en' => 'Build a portfolio that represents your brand',
                ],
                'subtitle' => [
                    'fr' => 'Design premium, contenu multilingue et performances rapides.',
                    'ar' => 'تصميم احترافي، محتوى متعدد اللغات وأداء سريع.',
                    'en' => 'Premium design, multilingual content, and fast performance.',
                ],
                'content' => [
                    'fr' => 'Gérez vos sections, services et projets depuis une seule interface admin.',
                    'ar' => 'أدر أقسام الصفحة والخدمات والمشاريع من لوحة إدارة واحدة.',
                    'en' => 'Manage homepage sections, services, and projects from one admin panel.',
                ],
                'cta_label' => ['fr' => 'Découvrir les projets', 'ar' => 'اكتشف المشاريع', 'en' => 'Explore projects'],
                'cta_link' => '/projects',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'section_type' => HomeSection::TYPE_ABOUT_INTRO,
                'section_key' => 'about_intro',
                'title' => [
                    'fr' => 'Une équipe orientée résultats',
                    'ar' => 'فريق يركز على النتائج',
                    'en' => 'A team focused on outcomes',
                ],
                'subtitle' => [
                    'fr' => 'Stratégie, UX et développement moderne.',
                    'ar' => 'استراتيجية وتجربة مستخدم وتطوير حديث.',
                    'en' => 'Strategy, UX, and modern development.',
                ],
                'content' => [
                    'fr' => 'Nous accompagnons les marques pour transformer leurs réalisations en expériences web convaincantes.',
                    'ar' => 'نرافق العلامات التجارية لتحويل إنجازاتها إلى تجربة ويب مقنعة.',
                    'en' => 'We help brands turn their achievements into compelling digital experiences.',
                ],
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'section_type' => HomeSection::TYPE_FEATURED_PROJECTS,
                'section_key' => 'featured_projects',
                'title' => [
                    'fr' => 'Projets à la une',
                    'ar' => 'مشاريع مميزة',
                    'en' => 'Featured projects',
                ],
                'subtitle' => [
                    'fr' => 'Une sélection de nos dernières réalisations.',
                    'ar' => 'مختارات من أحدث أعمالنا.',
                    'en' => 'A curated set of our latest work.',
                ],
                'cta_label' => ['fr' => 'Voir tout', 'ar' => 'عرض الكل', 'en' => 'See all'],
                'cta_link' => '/projects',
                'sort_order' => 30,
                'is_active' => true,
            ],
            [
                'section_type' => HomeSection::TYPE_SERVICES,
                'section_key' => 'services',
                'title' => [
                    'fr' => 'Nos services',
                    'ar' => 'خدماتنا',
                    'en' => 'Our services',
                ],
                'subtitle' => [
                    'fr' => 'Du cadrage à la mise en ligne.',
                    'ar' => 'من التخطيط حتى الإطلاق.',
                    'en' => 'From discovery to launch.',
                ],
                'sort_order' => 40,
                'is_active' => true,
            ],
            [
                'section_type' => HomeSection::TYPE_TESTIMONIALS,
                'section_key' => 'testimonials',
                'title' => [
                    'fr' => 'Ce que disent nos clients',
                    'ar' => 'ماذا يقول عملاؤنا',
                    'en' => 'What our clients say',
                ],
                'subtitle' => [
                    'fr' => 'Des retours concrets sur nos collaborations.',
                    'ar' => 'آراء حقيقية حول تجارب التعاون معنا.',
                    'en' => 'Real feedback from our partnerships.',
                ],
                'sort_order' => 50,
                'is_active' => true,
            ],
            [
                'section_type' => HomeSection::TYPE_CTA_BLOCK,
                'section_key' => 'cta_block',
                'title' => [
                    'fr' => 'Prêt à lancer votre prochain projet ?',
                    'ar' => 'جاهز لإطلاق مشروعك القادم؟',
                    'en' => 'Ready to launch your next project?',
                ],
                'subtitle' => [
                    'fr' => 'Parlons de vos objectifs.',
                    'ar' => 'دعنا نتحدث عن أهدافك.',
                    'en' => 'Let’s discuss your goals.',
                ],
                'content' => [
                    'fr' => 'Planifions un échange pour construire une page d’accueil qui convertit.',
                    'ar' => 'لنحدد جلسة سريعة لبناء صفحة رئيسية تحقق النتائج.',
                    'en' => 'Book a quick call and build a homepage that converts.',
                ],
                'cta_label' => ['fr' => 'Nous contacter', 'ar' => 'تواصل معنا', 'en' => 'Contact us'],
                'cta_link' => '/contact',
                'sort_order' => 60,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            HomeSection::updateOrCreate(
                ['section_key' => $section['section_key']],
                $section
            );
        }
    }
}
