<?php

return [
    'default_locale' => 'fr',

    'locales' => ['fr', 'ar', 'en'],

    'rtl_locales' => ['ar'],

    'modules' => [
        'settings',
        'pages',
        'projects',
        'services',
        'testimonials',
        'contact_messages',
        'media_assets',
        'users_roles',
    ],

    'home_sections' => [
        'types' => [
            'hero' => [
                'label' => 'Hero',
                'view' => 'front.home.sections.hero',
            ],
            'about_intro' => [
                'label' => 'About intro',
                'view' => 'front.home.sections.about-intro',
            ],
            'featured_projects' => [
                'label' => 'Featured projects',
                'view' => 'front.home.sections.featured-projects',
            ],
            'services' => [
                'label' => 'Services',
                'view' => 'front.home.sections.services',
            ],
            'testimonials' => [
                'label' => 'Testimonials',
                'view' => 'front.home.sections.testimonials',
            ],
            'cta_block' => [
                'label' => 'CTA block',
                'view' => 'front.home.sections.cta-block',
            ],
        ],
    ],
];
