<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreProjectRequest;
use App\Http\Requests\Admin\Content\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Support\Media\MediaManager;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $sortable = ['sort_order', 'project_date', 'created_at'];
        $sort = $request->string('sort', 'sort_order')->toString();
        if (! in_array($sort, $sortable, true)) {
            $sort = 'sort_order';
        }

        $direction = $request->string('direction', 'asc')->toString() === 'desc' ? 'desc' : 'asc';

        $projects = Project::query()
            ->with('category')
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('slug', 'like', "%{$search}%")
                    ->orWhere('title->en', 'like', "%{$search}%")
                    ->orWhere('title->fr', 'like', "%{$search}%")
                    ->orWhere('title->ar', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%");
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', (int) $request->integer('category_id')))
            ->when($request->filled('published'), fn ($query) => $query->where('is_published', (bool) $request->integer('published')))
            ->when($request->filled('featured'), fn ($query) => $query->where('is_featured', (bool) $request->integer('featured')))
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        $categories = ProjectCategory::ordered()->get();

        return view('admin.content.projects.index', compact('projects', 'categories'));
    }

    public function create(): View
    {
        return view('admin.content.projects.form', [
            'project' => new Project(),
            'categories' => ProjectCategory::ordered()->get(),
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $this->normalizePayload($request->validated());

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('projects/featured', 'public');
        }

        if ($request->hasFile('seo_og_image')) {
            $seo = $data['seo'] ?? [];
            $seo['og_image'] = $request->file('seo_og_image')->store('projects/seo', 'public');
            $data['seo'] = $seo;
        }

        $data['gallery'] = $this->syncGallery([], $request);

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('status', 'Project created.');
    }

    public function edit(Project $project): View
    {
        return view('admin.content.projects.form', [
            'project' => $project,
            'categories' => ProjectCategory::ordered()->get(),
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $this->normalizePayload($request->validated());

        if ($request->hasFile('featured_image')) {
            if ($project->featured_image) {
                MediaManager::deletePublic($project->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('projects/featured', 'public');
        } else {
            unset($data['featured_image']);
        }

        if ($request->hasFile('seo_og_image')) {
            if (! empty($project->seo['og_image'])) {
                MediaManager::deletePublic($project->seo['og_image']);
            }
            $seo = $data['seo'] ?? $project->seo ?? [];
            $seo['og_image'] = $request->file('seo_og_image')->store('projects/seo', 'public');
            $data['seo'] = $seo;
        }

        $data['gallery'] = $this->syncGallery($project->gallery ?? [], $request);

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->featured_image) {
            MediaManager::deletePublic($project->featured_image);
        }

        foreach ($project->gallery ?? [] as $path) {
            MediaManager::deletePublic($path);
        }

        if (! empty($project->seo['og_image'])) {
            MediaManager::deletePublic($project->seo['og_image']);
        }

        $project->delete();

        return back()->with('status', 'Project deleted.');
    }

    private function normalizePayload(array $data): array
    {
        $technologies = collect(explode(',', Arr::pull($data, 'technologies', '')))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $data['technologies'] = $technologies;

        return $data;
    }

    private function syncGallery(array $existingGallery, Request $request): array
    {
        $kept = collect($request->input('existing_gallery', []))
            ->filter(fn ($path) => in_array($path, $existingGallery, true))
            ->values()
            ->all();

        $deleted = array_values(array_diff($existingGallery, $kept));
        foreach ($deleted as $path) {
            MediaManager::deletePublic($path);
        }

        $uploads = [];
        foreach ($request->file('gallery_uploads', []) as $file) {
            if ($file) {
                $uploads[] = $file->store('projects/gallery', 'public');
            }
        }

        return array_values(array_merge($kept, $uploads));
    }
}
