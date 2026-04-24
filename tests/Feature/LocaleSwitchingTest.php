<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleSwitchingTest extends TestCase
{
    use RefreshDatabase;

    public function test_switching_language_keeps_the_same_frontoffice_path_when_localized(): void
    {
        $this->from('/en/projects')
            ->get('/language/fr')
            ->assertRedirect('/fr/projects');

        $this->assertSame('fr', session('locale'));
    }

    public function test_switching_language_from_non_localized_path_redirects_to_localized_home(): void
    {
        $this->from('/admin/login')
            ->get('/language/ar')
            ->assertRedirect('/ar');

        $this->assertSame('ar', session('locale'));
    }
}
