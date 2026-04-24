<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreBlogPostRequest;
use App\Http\Requests\Admin\Content\UpdateBlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index(Request $request): View
    {
        $blogPosts = BlogPost::query()
            ->with('category')
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('slug', 'like', "%{$search}%")
                    ->orWhere('title->en', 'like', "%{$search}%")
                    ->orWhere('title->fr', 'like', "%{$search}%")
                    ->orWhere('title->ar', 'like', "%{$search}%");
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', (int) $request->integer('category_id')))
            ->when($request->filled('published'), fn ($query) => $query->where('is_published', (bool) $request->integer('published')))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        $categories = BlogCategory::ordered()->get();

        return view('admin.content.blog-posts.index', compact('blogPosts', 'categories'));
    }

    public function create(): View
    {
        return view('admin.content.blog-posts.form', [
            'blogPost' => new BlogPost(),
            'categories' => BlogCategory::ordered()->get(),
        ]);
    }

    public function store(StoreBlogPostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        if ($request->hasFile('seo_og_image')) {
            $seo = $data['seo'] ?? [];
            $seo['og_image'] = $request->file('seo_og_image')->store('blog/seo', 'public');
            $data['seo'] = $seo;
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog-posts.index')->with('status', 'Blog post created.');
    }

    public function edit(BlogPost $blogPost): View
    {
        return view('admin.content.blog-posts.form', [
            'blogPost' => $blogPost,
            'categories' => BlogCategory::ordered()->get(),
        ]);
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }

            $data['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        } else {
            unset($data['featured_image']);
        }

        if ($request->hasFile('seo_og_image')) {
            if (! empty($blogPost->seo['og_image'])) {
                Storage::disk('public')->delete($blogPost->seo['og_image']);
            }

            $seo = $data['seo'] ?? $blogPost->seo ?? [];
            $seo['og_image'] = $request->file('seo_og_image')->store('blog/seo', 'public');
            $data['seo'] = $seo;
        }

        $blogPost->update($data);

        return redirect()->route('admin.blog-posts.index')->with('status', 'Blog post updated.');
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
        }

        if (! empty($blogPost->seo['og_image'])) {
            Storage::disk('public')->delete($blogPost->seo['og_image']);
        }

        $blogPost->delete();

        return back()->with('status', 'Blog post deleted.');
    }
}
