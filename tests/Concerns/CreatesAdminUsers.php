<?php

namespace Tests\Concerns;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

trait CreatesAdminUsers
{
    protected function makeAdminUserWithRole(string $roleName, array $permissions): User
    {
        $role = Role::factory()->create([
            'name' => $roleName,
            'label' => ucfirst(str_replace('_', ' ', $roleName)),
        ]);

        foreach ($permissions as $permission) {
            $perm = Permission::factory()->create([
                'name' => $permission,
                'label' => ucfirst(str_replace('_', ' ', $permission)),
            ]);

            $role->permissions()->syncWithoutDetaching([$perm->id]);
        }

        $user = User::factory()->create(['is_admin' => true, 'is_active' => true]);
        $user->roles()->sync([$role->id]);

        return $user;
    }
}
