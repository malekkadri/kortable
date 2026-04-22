<?php

namespace Database\Seeders;

use App\Services\SettingService;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        /** @var SettingService $settings */
        $settings = app(SettingService::class);

        $settings->set('general', 'site_name', [
            'fr' => 'Kortable',
            'ar' => 'كورتابل',
            'en' => 'Kortable',
        ]);

        $settings->set('homepage', 'homepage_headline', [
            'fr' => 'Bienvenue sur Kortable',
            'ar' => 'مرحبًا بكم في كورتابل',
            'en' => 'Welcome to Kortable',
        ]);
    }
}
