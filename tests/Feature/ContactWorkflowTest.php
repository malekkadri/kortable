<?php

namespace Tests\Feature;

use App\Mail\NewContactMessageNotification;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Concerns\CreatesAdminUsers;
use Tests\TestCase;

class ContactWorkflowTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUsers;

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
            'submitted_at' => now()->subSeconds(5)->timestamp,
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
            'submitted_at' => now()->subSeconds(5)->timestamp,
        ])->assertSessionHasErrors('company_website');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_submissions_that_are_too_fast_are_rejected_as_spam(): void
    {
        $this->post('/en/contact', [
            'name' => 'Fast Bot',
            'email' => 'fast@example.com',
            'subject' => 'Spam',
            'message' => 'Spam content',
            'company_website' => '',
            'submitted_at' => now()->timestamp,
        ])->assertSessionHasErrors('submitted_at');

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
}
