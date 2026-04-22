<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_editor_can_access_admin_dashboard_but_not_user_management(): void
    {
        $editor = $this->makeAdminUserWithRole('editor', ['manage_pages']);

        $this->actingAs($editor)
            ->get('/admin')
            ->assertOk();

        $this->actingAs($editor)
            ->get('/admin/users')
            ->assertForbidden();
    }

    public function test_super_admin_can_access_user_management(): void
    {
        $superAdmin = $this->makeAdminUserWithRole('super_admin', ['manage_users']);

        $this->actingAs($superAdmin)
            ->get('/admin/users')
            ->assertOk();
    }

    private function makeAdminUserWithRole(string $roleName, array $permissions): User
    {
        $role = Role::factory()->create(['name' => $roleName, 'label' => ucfirst(str_replace('_', ' ', $roleName))]);

        foreach ($permissions as $permission) {
            $perm = Permission::factory()->create(['name' => $permission, 'label' => ucfirst(str_replace('_', ' ', $permission))]);
            $role->permissions()->syncWithoutDetaching([$perm->id]);
        }

        $user = User::factory()->create(['is_admin' => true, 'is_active' => true]);
        $user->roles()->sync([$role->id]);

        return $user;
    }
}
