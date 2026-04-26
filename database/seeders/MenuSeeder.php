<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $about = Page::where('slug', 'about')->first();
        $contact = Page::where('slug', 'contact')->first();

        $header = Menu::updateOrCreate(['location' => 'header'], ['name' => 'Header Menu', 'is_active' => true]);
        $footer = Menu::updateOrCreate(['location' => 'footer'], ['name' => 'Footer Menu', 'is_active' => true]);

        MenuItem::query()->whereIn('menu_id', [$header->id, $footer->id])->delete();

        MenuItem::create([
            'menu_id' => $header->id,
            'label' => ['fr' => 'Accueil', 'ar' => 'الرئيسية', 'en' => 'Home'],
            'type' => 'custom',
            'custom_url' => '/',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        MenuItem::create([
            'menu_id' => $header->id,
            'label' => ['fr' => 'À propos', 'ar' => 'من نحن', 'en' => 'About'],
            'type' => 'page',
            'linked_page_id' => $about?->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        MenuItem::create([
            'menu_id' => $header->id,
            'label' => ['fr' => 'Projets', 'ar' => 'المشاريع', 'en' => 'Projects'],
            'type' => 'custom',
            'custom_url' => '/projects',
            'sort_order' => 3,
            'is_active' => true,
        ]);
        MenuItem::create([
            'menu_id' => $header->id,
            'label' => ['fr' => 'Services', 'ar' => 'الخدمات', 'en' => 'Services'],
            'type' => 'custom',
            'custom_url' => '/services',
            'sort_order' => 4,
            'is_active' => true,
        ]);
        MenuItem::create([
            'menu_id' => $header->id,
            'label' => ['fr' => 'Blog', 'ar' => 'المدونة', 'en' => 'Blog'],
            'type' => 'blog_index',
            'sort_order' => 5,
            'is_active' => true,
        ]);
        MenuItem::create([
            'menu_id' => $header->id,
            'label' => ['fr' => 'Contact', 'ar' => 'اتصل بنا', 'en' => 'Contact'],
            'type' => 'page',
            'linked_page_id' => $contact?->id,
            'sort_order' => 6,
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $footer->id,
            'label' => ['fr' => 'À propos', 'ar' => 'من نحن', 'en' => 'About'],
            'type' => 'page',
            'linked_page_id' => $about?->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        MenuItem::create([
            'menu_id' => $footer->id,
            'label' => ['fr' => 'Services', 'ar' => 'الخدمات', 'en' => 'Services'],
            'type' => 'custom',
            'custom_url' => '/services',
            'sort_order' => 2,
            'is_active' => true,
        ]);
        MenuItem::create([
            'menu_id' => $footer->id,
            'label' => ['fr' => 'Contact', 'ar' => 'اتصل بنا', 'en' => 'Contact'],
            'type' => 'page',
            'linked_page_id' => $contact?->id,
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }
}
