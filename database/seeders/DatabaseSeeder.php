<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            SiteSettingSeeder::class,
            PageSeeder::class,
            HomeSectionSeeder::class,
            ProjectCategorySeeder::class,
            ProjectSeeder::class,
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
            ServiceSeeder::class,
            TestimonialSeeder::class,
            ContactMessageSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
