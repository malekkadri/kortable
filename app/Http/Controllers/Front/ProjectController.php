<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\SiteSetting;
use App\Support\Seo\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categorySlug = $request->string('category')->toString();

        $projects = Project::query()
            ->with('category')
            ->published()
            ->when($categorySlug !== '', function ($query) use ($categorySlug) {
                $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                    $categoryQuery->active()->where('slug', $categorySlug);
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

        $siteSetting = SiteSetting::query()->first();
        $seo = SeoData::forContent(
            [],
            __('Projects').' | '.($siteSetting?->getLocalized('site_name', $locale) ?? config('app.name')),
            $siteSetting?->getLocalized('tagline', $locale)
        );
        $seo['canonical'] = route('front.projects.index', ['locale' => $locale]);

        return view('front.projects.index', compact('projects', 'featuredProjects', 'categories', 'categorySlug', 'seo'));
    }

    public function show(string $locale, Project $localizedProject): View|RedirectResponse
    {
        abort_unless($localizedProject->is_published && (! $localizedProject->published_at || $localizedProject->published_at->isPast()), 404);

        $project = $localizedProject->load('category');
        $localizedSlug = $project->localizedSlug($locale);

        $requestedSlug = (string) request()->route()->originalParameter('localizedProject');

        if ($requestedSlug !== $localizedSlug) {
            return redirect()->route('front.projects.show', ['locale' => $locale, 'localizedProject' => $localizedSlug], 301);
        }

        $relatedProjects = Project::query()
            ->with('category')
            ->published()
            ->where('id', '!=', $project->id)
            ->when($project->category_id, fn ($query) => $query->where('category_id', $project->category_id))
            ->ordered()
            ->take(3)
            ->get();

        $seo = SeoData::forContent(
            $project->seo ?? [],
            $project->getTranslated('title', $locale),
            $project->getTranslated('short_description', $locale),
            $project->featured_image
        );
        $seo['canonical'] = route('front.projects.show', ['locale' => $locale, 'localizedProject' => $localizedSlug]);

        return view('front.projects.show', compact('project', 'relatedProjects', 'seo'));
    }
}
