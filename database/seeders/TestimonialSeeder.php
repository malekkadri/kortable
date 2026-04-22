<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        Testimonial::updateOrCreate(
            ['author_name' => 'Sophie Martin'],
            [
                'author_role' => [
                    'fr' => 'Directrice Marketing',
                    'ar' => 'مديرة التسويق',
                    'en' => 'Marketing Director',
                ],
                'company' => 'Atelier Nova',
                'content' => [
                    'fr' => 'Le nouveau site a doublé nos demandes qualifiées en 3 mois.',
                    'ar' => 'الموقع الجديد ضاعف طلبات العملاء المؤهلين خلال 3 أشهر.',
                    'en' => 'The new website doubled qualified leads in 3 months.',
                ],
                'avatar' => 'testimonials/sophie.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}
