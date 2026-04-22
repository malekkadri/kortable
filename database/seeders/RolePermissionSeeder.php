<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::updateOrCreate(['name' => 'super_admin'], ['label' => 'Super Admin']);
        $editor = Role::updateOrCreate(['name' => 'editor'], ['label' => 'Editor']);

        $permissions = collect([
            'manage_users' => 'Manage users',
            'manage_settings' => 'Manage settings',
            'manage_pages' => 'Manage pages',
            'manage_projects' => 'Manage projects',
            'manage_services' => 'Manage services',
            'manage_messages' => 'Manage contact messages',
            'manage_menus' => 'Manage menus',
        ])->map(fn ($label, $name) => Permission::updateOrCreate(['name' => $name], ['label' => $label]));

        $superAdmin->permissions()->sync($permissions->pluck('id'));
        $editor->permissions()->sync($permissions->whereIn('name', [
            'manage_pages',
            'manage_projects',
            'manage_services',
            'manage_menus',
            'manage_messages',
        ])->pluck('id'));

        $admin = User::where('email', 'admin@kortable.test')->first();
        if ($admin) {
            $admin->roles()->syncWithoutDetaching([$superAdmin->id]);
            $admin->is_admin = true;
            $admin->save();
        }
    }
}
