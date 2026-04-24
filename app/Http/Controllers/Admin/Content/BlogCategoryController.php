<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreBlogCategoryRequest;
use App\Http\Requests\Admin\Content\UpdateBlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $blogCategories = BlogCategory::query()
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

        return view('admin.content.blog-categories.index', compact('blogCategories'));
    }

    public function create(): View
    {
        return view('admin.content.blog-categories.form', ['blogCategory' => new BlogCategory()]);
    }

    public function store(StoreBlogCategoryRequest $request): RedirectResponse
    {
        BlogCategory::create($request->validated());

        return redirect()->route('admin.blog-categories.index')->with('status', 'Blog category created.');
    }

    public function edit(BlogCategory $blogCategory): View
    {
        return view('admin.content.blog-categories.form', compact('blogCategory'));
    }

    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->update($request->validated());

        return redirect()->route('admin.blog-categories.index')->with('status', 'Blog category updated.');
    }

    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->delete();

        return back()->with('status', 'Blog category deleted.');
    }
}
