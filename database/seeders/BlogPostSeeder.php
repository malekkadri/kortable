<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $newsCategory = BlogCategory::query()->where('slug', 'news')->first();
        $insightsCategory = BlogCategory::query()->where('slug', 'insights')->first();

        BlogPost::updateOrCreate(
            ['slug' => 'launching-our-new-kortable-platform'],
            [
                'category_id' => $newsCategory?->id,
                'title' => [
                    'fr' => 'Lancement de notre nouvelle plateforme Kortable',
                    'ar' => 'إطلاق منصة Kortable الجديدة',
                    'en' => 'Launching our new Kortable platform',
                ],
                'slug_translations' => [
                    'fr' => 'lancement-nouvelle-plateforme-kortable',
                    'ar' => 'itlaq-mansat-kortable-aljadida',
                    'en' => 'launching-our-new-kortable-platform',
                ],
                'excerpt' => [
                    'fr' => 'Découvrez les nouveautés de la plateforme.',
                    'ar' => 'اكتشف مزايا المنصة الجديدة.',
                    'en' => 'Discover what is new in our platform.',
                ],
                'content' => [
                    'fr' => 'Nous avons entièrement repensé Kortable pour offrir une expérience éditoriale plus rapide et multilingue.',
                    'ar' => 'أعدنا تصميم Kortable بالكامل لتقديم تجربة تحرير أسرع ومتعددة اللغات.',
                    'en' => 'We rebuilt Kortable to deliver a faster multilingual publishing experience.',
                ],
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'seo' => [
                    'meta_title' => ['fr' => 'Nouveau Kortable', 'ar' => 'Kortable الجديد', 'en' => 'New Kortable'],
                    'meta_description' => ['fr' => 'Découvrez la nouvelle version.', 'ar' => 'تعرف على النسخة الجديدة.', 'en' => 'Meet the latest release.'],
                ],
            ]
        );

        BlogPost::updateOrCreate(
            ['slug' => 'how-to-structure-multilingual-content'],
            [
                'category_id' => $insightsCategory?->id,
                'title' => [
                    'fr' => 'Comment structurer un contenu multilingue',
                    'ar' => 'كيفية تنظيم المحتوى متعدد اللغات',
                    'en' => 'How to structure multilingual content',
                ],
                'slug_translations' => [
                    'fr' => 'comment-structurer-contenu-multilingue',
                    'ar' => 'kayfiyat-tanzim-almuhtawa-mutadid-allughat',
                    'en' => 'how-to-structure-multilingual-content',
                ],
                'excerpt' => [
                    'fr' => 'Bonnes pratiques pour gérer fr/ar/en proprement.',
                    'ar' => 'أفضل الممارسات لإدارة fr/ar/en بكفاءة.',
                    'en' => 'Best practices for managing fr/ar/en cleanly.',
                ],
                'content' => [
                    'fr' => 'Utilisez des champs traduisibles, des slugs localisés et un fallback clair pour garder la cohérence.',
                    'ar' => 'استخدم حقولاً قابلة للترجمة وروابط محلية مع fallback واضح للحفاظ على الاتساق.',
                    'en' => 'Use translatable fields, localized slugs, and clear fallbacks to keep consistency.',
                ],
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'seo' => [
                    'meta_title' => ['fr' => 'Contenu multilingue', 'ar' => 'محتوى متعدد اللغات', 'en' => 'Multilingual content'],
                    'meta_description' => ['fr' => 'Guide pratique.', 'ar' => 'دليل عملي.', 'en' => 'Practical guide.'],
                ],
            ]
        );

        BlogPost::updateOrCreate(
            ['slug' => 'editorial-workflow-update'],
            [
                'category_id' => $newsCategory?->id,
                'title' => [
                    'fr' => 'Mise à jour du workflow éditorial',
                    'ar' => 'تحديث سير العمل التحريري',
                    'en' => 'Editorial workflow update',
                ],
                'slug_translations' => [
                    'fr' => 'mise-a-jour-workflow-editorial',
                    'ar' => 'tahdith-sayr-alamal-altahriri',
                    'en' => 'editorial-workflow-update',
                ],
                'excerpt' => [
                    'fr' => 'Nouveau statut de publication et planification simplifiée.',
                    'ar' => 'حالة نشر جديدة وجدولة مبسطة.',
                    'en' => 'New publish status controls and easier scheduling.',
                ],
                'content' => [
                    'fr' => 'Les éditeurs peuvent désormais préparer des articles et les publier à une date précise.',
                    'ar' => 'يمكن للمحررين الآن تجهيز المقالات ونشرها في موعد محدد.',
                    'en' => 'Editors can now prepare posts and publish them at scheduled dates.',
                ],
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'seo' => [
                    'meta_title' => ['fr' => 'Workflow éditorial', 'ar' => 'سير العمل التحريري', 'en' => 'Editorial workflow'],
                    'meta_description' => ['fr' => 'Mise à jour des outils.', 'ar' => 'تحديث الأدوات.', 'en' => 'Tooling update.'],
                ],
            ]
        );
    }
}
