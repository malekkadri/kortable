<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::updateOrCreate(
            ['slug' => 'portfolio-design'],
            [
                'title' => ['fr' => 'Design Portfolio', 'ar' => 'تصميم البورتفوليو', 'en' => 'Portfolio Design'],
                'short_description' => [
                    'fr' => 'UI haut de gamme pour valoriser vos études de cas.',
                    'ar' => 'واجهة احترافية لعرض دراسات الحالة.',
                    'en' => 'Premium UI to elevate your case studies.',
                ],
                'description' => [
                    'fr' => 'Direction artistique, composants UI et responsive complet.',
                    'ar' => 'اتجاه فني ومكوّنات واجهة واستجابة كاملة.',
                    'en' => 'Art direction, component system, and full responsiveness.',
                ],
                'icon' => 'icon-palette',
                'image' => 'services/design.jpg',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}
