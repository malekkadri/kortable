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
        $home = Page::where('slug', 'home')->first();
        $about = Page::where('slug', 'about')->first();

        $header = Menu::updateOrCreate(['location' => 'header'], ['name' => 'Header Menu', 'is_active' => true]);
        $footer = Menu::updateOrCreate(['location' => 'footer'], ['name' => 'Footer Menu', 'is_active' => true]);

        $servicesItem = MenuItem::updateOrCreate(
            ['menu_id' => $header->id, 'sort_order' => 2],
            ['label' => ['fr' => 'Services', 'ar' => 'الخدمات', 'en' => 'Services'], 'type' => 'custom', 'custom_url' => '#services', 'is_active' => true]
        );

        MenuItem::updateOrCreate(
            ['menu_id' => $header->id, 'sort_order' => 1],
            ['label' => ['fr' => 'Accueil', 'ar' => 'الرئيسية', 'en' => 'Home'], 'type' => 'page', 'linked_page_id' => $home?->id, 'is_active' => true]
        );

        MenuItem::updateOrCreate(
            ['menu_id' => $header->id, 'parent_id' => $servicesItem->id, 'sort_order' => 3],
            ['label' => ['fr' => 'SEO', 'ar' => 'SEO', 'en' => 'SEO'], 'type' => 'custom', 'custom_url' => '#services', 'is_active' => true]
        );

        MenuItem::updateOrCreate(
            ['menu_id' => $footer->id, 'sort_order' => 1],
            ['label' => ['fr' => 'À propos', 'ar' => 'من نحن', 'en' => 'About'], 'type' => 'page', 'linked_page_id' => $about?->id, 'is_active' => true]
        );

        MenuItem::updateOrCreate(
            ['menu_id' => $footer->id, 'sort_order' => 2],
            ['label' => ['fr' => 'Contact', 'ar' => 'اتصل بنا', 'en' => 'Contact'], 'type' => 'custom', 'custom_url' => '/contact', 'is_active' => true]
        );
    }
}
