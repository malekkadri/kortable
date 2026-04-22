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
                'title' => [
                    'fr' => 'Accueil',
                    'ar' => 'الرئيسية',
                    'en' => 'Home',
                ],
                'excerpt' => [
                    'fr' => 'Contenu piloté depuis l’administration.',
                    'ar' => 'محتوى ديناميكي تتم إدارته من لوحة الإدارة.',
                    'en' => 'Dynamic content managed from the admin panel.',
                ],
                'body' => [
                    'fr' => 'Cette section est un exemple de contenu dynamique multilingue.',
                    'ar' => 'هذا القسم مثال على محتوى ديناميكي متعدد اللغات.',
                    'en' => 'This section is an example of multilingual dynamic content.',
                ],
            ]
        );
    }
}
