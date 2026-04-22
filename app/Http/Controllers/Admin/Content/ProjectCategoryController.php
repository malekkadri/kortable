<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreProjectCategoryRequest;
use App\Http\Requests\Admin\Content\UpdateProjectCategoryRequest;
use App\Models\ProjectCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = ProjectCategory::query()
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('slug', 'like', "%{$search}%")
                    ->orWhere('name->en', 'like', "%{$search}%")
                    ->orWhere('name->fr', 'like', "%{$search}%")
                    ->orWhere('name->ar', 'like', "%{$search}%");
            })
            ->when($request->filled('active'), fn ($query) => $query->where('is_active', (bool) $request->integer('active')))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.content.project-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.content.project-categories.form', ['projectCategory' => new ProjectCategory()]);
    }

    public function store(StoreProjectCategoryRequest $request): RedirectResponse
    {
        ProjectCategory::create($request->validated());

        return redirect()->route('admin.project-categories.index')->with('status', 'Project category created.');
    }

    public function edit(ProjectCategory $projectCategory): View
    {
        return view('admin.content.project-categories.form', compact('projectCategory'));
    }

    public function update(UpdateProjectCategoryRequest $request, ProjectCategory $projectCategory): RedirectResponse
    {
        $projectCategory->update($request->validated());

        return redirect()->route('admin.project-categories.index')->with('status', 'Project category updated.');
    }

    public function destroy(ProjectCategory $projectCategory): RedirectResponse
    {
        $projectCategory->delete();

        return back()->with('status', 'Project category deleted.');
    }
}
