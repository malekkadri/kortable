<?php

namespace Tests\Feature;

use App\Mail\NewContactMessageNotification;
use App\Models\ContactMessage;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission_persists_message_and_sends_notification(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Amina',
            'email' => 'amina@example.com',
            'phone' => '+21260000000',
            'subject' => 'Portfolio inquiry',
            'message' => 'Hello, I need a redesign.',
            'company_website' => '',
        ];

        $this->post('/en/contact', $payload)
            ->assertRedirect('/en/contact')
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'amina@example.com',
            'status' => 'new',
        ]);

        Mail::assertSent(NewContactMessageNotification::class);
    }

    public function test_honeypot_field_blocks_spam_submission(): void
    {
        $this->post('/en/contact', [
            'name' => 'Spam Bot',
            'email' => 'spam@example.com',
            'subject' => 'Spam',
            'message' => 'Spam content',
            'company_website' => 'https://spam.test',
        ])->assertSessionHasErrors('company_website');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_admin_contact_messages_are_protected_and_manageable(): void
    {
        ContactMessage::create([
            'name' => 'Lead',
            'email' => 'lead@example.com',
            'subject' => 'Need quote',
            'message' => 'Please send quote',
        ]);

        $this->get('/admin/contact-messages')->assertRedirect('/admin/login');

        $manager = $this->makeAdminUserWithRole('editor', ['manage_messages']);

        $this->actingAs($manager)
            ->get('/admin/contact-messages')
            ->assertOk()
            ->assertSee('lead@example.com');

        $message = ContactMessage::firstOrFail();

        $this->actingAs($manager)
            ->get('/admin/contact-messages/'.$message->id)
            ->assertOk();

        $message->refresh();
        $this->assertSame('read', $message->status);

        $this->actingAs($manager)
            ->put('/admin/contact-messages/'.$message->id, [
                'status' => 'replied',
                'notes' => 'Followed up by phone.',
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'status' => 'replied',
            'notes' => 'Followed up by phone.',
        ]);
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
