<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            RolePermissionSeeder::class,
            SettingSeeder::class,
            SiteSettingSeeder::class,
            PageSeeder::class,
            HomeSectionSeeder::class,
            ProjectCategorySeeder::class,
            ProjectSeeder::class,
            ServiceSeeder::class,
            TestimonialSeeder::class,
            ContactMessageSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
