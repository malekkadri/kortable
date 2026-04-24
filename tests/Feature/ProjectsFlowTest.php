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

    public function test_unpublished_projects_are_hidden_from_public_listing_and_detail(): void
    {
        $category = ProjectCategory::create([
            'name' => ['fr' => 'Branding', 'ar' => 'هوية', 'en' => 'Branding'],
            'slug' => 'branding',
            'description' => ['fr' => 'desc', 'ar' => 'وصف', 'en' => 'desc'],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Project::create([
            'category_id' => $category->id,
            'slug' => 'public-project',
            'slug_translations' => ['fr' => 'projet-public', 'ar' => 'mashrou-public', 'en' => 'public-project'],
            'title' => ['fr' => 'Public', 'ar' => 'عام', 'en' => 'Public'],
            'short_description' => ['fr' => 'Court', 'ar' => 'قصير', 'en' => 'Short'],
            'description' => ['fr' => 'Long FR', 'ar' => 'Long AR', 'en' => 'Long EN'],
            'is_published' => true,
            'technologies' => ['Laravel'],
            'gallery' => [],
            'seo' => [],
        ]);

        $hidden = Project::create([
            'category_id' => $category->id,
            'slug' => 'hidden-project',
            'slug_translations' => ['fr' => 'projet-prive', 'ar' => 'mashrou-private', 'en' => 'hidden-project'],
            'title' => ['fr' => 'Privé', 'ar' => 'خاص', 'en' => 'Private'],
            'short_description' => ['fr' => 'Court', 'ar' => 'قصير', 'en' => 'Short'],
            'description' => ['fr' => 'Long FR', 'ar' => 'Long AR', 'en' => 'Long EN'],
            'is_published' => false,
            'technologies' => ['Laravel'],
            'gallery' => [],
            'seo' => [],
        ]);

        $this->get('/en/projects')
            ->assertOk()
            ->assertSee('Public')
            ->assertDontSee('Private');

        $this->get('/en/projects/'.$hidden->localizedSlug('en'))
            ->assertNotFound();
    }
}
