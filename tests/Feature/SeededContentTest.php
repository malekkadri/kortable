<?php

namespace Tests\Feature;

use App\Models\HomeSection;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeededContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_seed_contains_multilingual_content_in_fr_ar_en(): void
    {
        $this->seed(DatabaseSeeder::class);

        $models = [
            Page::query()->firstOrFail(),
            HomeSection::query()->firstOrFail(),
            Project::query()->firstOrFail(),
            Service::query()->firstOrFail(),
            SiteSetting::query()->firstOrFail(),
        ];

        foreach ($models as $model) {
            $payload = collect($model->getAttributes())
                ->filter(fn ($value) => is_array($value) && isset($value['fr'], $value['ar'], $value['en']));

            $this->assertNotEmpty($payload, sprintf('No multilingual payload found for %s', $model::class));
        }
    }
}
