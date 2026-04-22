<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => ['fr' => 'Kortable Studio', 'ar' => 'استوديو كورتابل', 'en' => 'Kortable Studio'],
                'tagline' => ['fr' => 'Portfolios numériques qui convertissent.', 'ar' => 'مواقع بورتفوليو رقمية تحقق النتائج.', 'en' => 'Digital portfolio websites that convert.'],
                'logo' => null,
                'favicon' => null,
                'default_locale' => 'fr',
                'contact_email' => 'hello@kortable.test',
                'phone' => '+1 415 555 0138',
                'address' => ['fr' => '750 Market St, San Francisco, CA', 'ar' => '750 شارع ماركت، سان فرانسيسكو، كاليفورنيا', 'en' => '750 Market St, San Francisco, CA'],
                'social_links' => ['linkedin' => 'https://www.linkedin.com/company/kortable', 'instagram' => 'https://www.instagram.com/kortable', 'github' => 'https://github.com/kortable'],
                'seo_defaults' => [
                    'title' => ['fr' => 'Kortable Studio', 'ar' => 'استوديو كورتابل', 'en' => 'Kortable Studio'],
                    'description' => ['fr' => 'Agence portfolio multilingue orientée performance.', 'ar' => 'وكالة مواقع بورتفوليو متعددة اللغات.', 'en' => 'A multilingual portfolio agency focused on performance.'],
                    'og_image' => 'seo/default-og.jpg',
                ],
                'footer_content' => [
                    'fr' => '© Kortable Studio. Tous droits réservés.',
                    'ar' => '© استوديو كورتابل. جميع الحقوق محفوظة.',
                    'en' => '© Kortable Studio. All rights reserved.',
                ],
            ]
        );
    }
}
