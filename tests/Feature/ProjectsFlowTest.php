<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_listing_and_detail_work_in_all_locales(): void
    {
        $category = ProjectCategory::create([
            'name' => ['fr' => 'Web', 'ar' => 'ويب', 'en' => 'Web'],
            'slug' => 'web',
            'description' => ['fr' => 'desc', 'ar' => 'وصف', 'en' => 'desc'],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $project = Project::create([
            'category_id' => $category->id,
            'slug' => 'alpha-project',
            'slug_translations' => [
                'fr' => 'projet-alpha',
                'ar' => 'mashrou-alpha',
                'en' => 'alpha-project',
            ],
            'title' => ['fr' => 'Projet Alpha', 'ar' => 'مشروع ألفا', 'en' => 'Alpha Project'],
            'short_description' => ['fr' => 'Court', 'ar' => 'قصير', 'en' => 'Short'],
            'description' => ['fr' => 'Long FR', 'ar' => 'Long AR', 'en' => 'Long EN'],
            'is_published' => true,
            'is_featured' => true,
            'technologies' => ['Laravel'],
            'gallery' => [],
            'seo' => [],
        ]);

        foreach (['fr', 'ar', 'en'] as $locale) {
            $this->get("/{$locale}/projects")
                ->assertOk()
                ->assertSee($project->title[$locale]);

            $this->get("/{$locale}/projects/{$project->localizedSlug($locale)}")
                ->assertOk()
                ->assertSee($project->title[$locale]);
        }
    }
}
