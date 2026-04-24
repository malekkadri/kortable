<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUsers;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUsers;

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
}
