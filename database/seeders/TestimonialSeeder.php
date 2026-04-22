<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['author_name' => 'Sophie Martin', 'company' => 'Atelier Nova'],
            ['author_name' => 'Yassine Khouri', 'company' => 'YK Studio'],
            ['author_name' => 'Emma Reed', 'company' => 'Northline Creative'],
        ];

        foreach ($rows as $index => $row) {
            Testimonial::updateOrCreate(
                ['author_name' => $row['author_name']],
                [
                    'author_role' => ['fr' => 'Directrice Marketing', 'ar' => 'مدير التسويق', 'en' => 'Marketing Director'],
                    'company' => $row['company'],
                    'content' => ['fr' => 'Excellent résultat avec impact business réel.', 'ar' => 'نتيجة ممتازة وتأثير حقيقي على الأعمال.', 'en' => 'Excellent outcome with real business impact.'],
                    'rating' => 5,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
