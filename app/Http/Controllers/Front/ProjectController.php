<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categorySlug = $request->string('category')->toString();

        $projects = Project::query()
            ->with('category')
            ->published()
            ->when($categorySlug !== '', function ($query) use ($categorySlug, $locale) {
                $query->whereHas('category', function ($categoryQuery) use ($categorySlug, $locale) {
                    $categoryQuery->where('slug', $categorySlug)
                        ->orWhere("name->{$locale}", $categorySlug);
                });
            })
            ->ordered()
            ->paginate(9)
            ->withQueryString();

        $featuredProjects = Project::query()
            ->with('category')
            ->published()
            ->featured()
            ->ordered()
            ->take(3)
            ->get();

        $categories = ProjectCategory::query()
            ->active()
            ->ordered()
            ->withCount(['projects' => fn ($query) => $query->published()])
            ->get();

        return view('front.projects.index', compact('projects', 'featuredProjects', 'categories', 'categorySlug'));
    }

    public function show(string $locale, Project $localizedProject): View
    {
        abort_unless($localizedProject->is_published, 404);

        $project = $localizedProject->load('category');

        $relatedProjects = Project::query()
            ->with('category')
            ->published()
            ->where('id', '!=', $project->id)
            ->when($project->category_id, fn ($query) => $query->where('category_id', $project->category_id))
            ->ordered()
            ->take(3)
            ->get();

        return view('front.projects.show', compact('project', 'relatedProjects'));
    }
}
