<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_is_redirected_to_dashboard(): void
    {
        User::factory()->create([
            'email' => 'admin@example.test',
            'password' => Hash::make('secret-1234'),
            'is_admin' => true,
            'is_active' => true,
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.test',
            'password' => 'secret-1234',
        ])->assertRedirect('/admin');

        $this->assertAuthenticated();
    }

    public function test_non_admin_credentials_are_rejected_on_admin_login(): void
    {
        User::factory()->create([
            'email' => 'member@example.test',
            'password' => Hash::make('secret-1234'),
            'is_admin' => false,
            'is_active' => true,
        ]);

        $this->from('/admin/login')->post('/admin/login', [
            'email' => 'member@example.test',
            'password' => 'secret-1234',
        ])->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $this->from('/admin/login')->post('/admin/login', [
            'email' => 'missing@example.test',
            'password' => 'wrong',
        ])->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
