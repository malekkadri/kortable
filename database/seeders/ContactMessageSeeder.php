<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        ContactMessage::updateOrCreate(
            ['email' => 'prospect@example.com', 'subject' => 'Nouveau projet portfolio'],
            [
                'name' => 'Alex Jordan',
                'phone' => '+1 650 555 0199',
                'message' => 'Bonjour, nous souhaitons moderniser notre portfolio multi-pays.',
                'status' => 'new',
                'notes' => null,
            ]
        );
    }
}
