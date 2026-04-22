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
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $editorRole = Role::where('name', 'editor')->first();

        $admin = User::updateOrCreate(
            ['email' => 'admin@kortable.test'],
            [
                'name' => 'Kortable Super Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_active' => true,
            ]
        );

        if ($superAdminRole) {
            $admin->roles()->sync([$superAdminRole->id]);
        }

        $editor = User::updateOrCreate(
            ['email' => 'editor@kortable.test'],
            [
                'name' => 'Kortable Editor',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_active' => true,
            ]
        );

        if ($editorRole) {
            $editor->roles()->sync([$editorRole->id]);
        }
    }
}
