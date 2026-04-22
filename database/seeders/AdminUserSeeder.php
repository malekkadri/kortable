<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kortable.test'],
            [
                'name' => 'Kortable Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@kortable.test'],
            [
                'name' => 'Kortable Editor',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );
    }
}
