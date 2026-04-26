<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production') && ! filter_var((string) env('ALLOW_DEMO_ADMIN_SEED', 'false'), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        $superAdminRole = Role::where('name', 'super_admin')->first();
        $editorRole = Role::where('name', 'editor')->first();

        $admin = User::updateOrCreate(
            ['email' => env('DEV_ADMIN_EMAIL', 'local-admin@invalid.local')],
            [
                'name' => 'Kortable Super Admin',
                'password' => Hash::make(env('DEV_ADMIN_PASSWORD', 'Admin@123456')),
                'is_admin' => true,
                'is_active' => true,
            ]
        );

        if ($superAdminRole) {
            $admin->roles()->sync([$superAdminRole->id]);
        }

        $editor = User::updateOrCreate(
            ['email' => env('DEV_EDITOR_EMAIL', 'local-editor@invalid.local')],
            [
                'name' => 'Kortable Editor',
                'password' => Hash::make(env('DEV_EDITOR_PASSWORD', 'Editor@123456')),
                'is_admin' => true,
                'is_active' => true,
            ]
        );

        if ($editorRole) {
            $editor->roles()->sync([$editorRole->id]);
        }
    }
}
