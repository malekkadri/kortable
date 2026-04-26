<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\SiteSetting;
use App\Support\Seo\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categorySlug = $request->string('category')->toString();

        $blogPosts = BlogPost::query()
            ->with('category')
            ->published()
            ->when($categorySlug !== '', function ($query) use ($categorySlug) {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->active()->where('slug', $categorySlug));
            })
            ->ordered()
            ->paginate(9)
            ->withQueryString();

        $categories = BlogCategory::query()
            ->active()
            ->ordered()
            ->withCount(['posts' => fn ($query) => $query->published()])
            ->get();

        $siteSetting = SiteSetting::query()->first();
        $seo = SeoData::forContent(
            [],
            __('Blog').' | '.($siteSetting?->getLocalized('site_name', $locale) ?? config('app.name')),
            $siteSetting?->getLocalized('tagline', $locale)
        );
        $seo['canonical'] = route('front.blog.index', ['locale' => $locale]);

        return view('front.blog.index', compact('blogPosts', 'categories', 'categorySlug', 'seo'));
    }

    public function show(string $locale, BlogPost $localizedBlogPost): View|RedirectResponse
    {
        abort_unless($localizedBlogPost->is_published && (! $localizedBlogPost->published_at || $localizedBlogPost->published_at->isPast()), 404);

        $blogPost = $localizedBlogPost->load('category');
        $localizedSlug = $blogPost->localizedSlug($locale);

        $requestedSlug = (string) request()->route()->originalParameter('localizedBlogPost');

        if ($requestedSlug !== $localizedSlug) {
            return redirect()->route('front.blog.show', ['locale' => $locale, 'localizedBlogPost' => $localizedSlug], 301);
        }

        $relatedPosts = BlogPost::query()
            ->with('category')
            ->published()
            ->where('id', '!=', $blogPost->id)
            ->when($blogPost->category_id, fn ($query) => $query->where('category_id', $blogPost->category_id))
            ->ordered()
            ->take(3)
            ->get();

        $seo = SeoData::forContent(
            $blogPost->seo ?? [],
            $blogPost->getTranslated('title', $locale),
            $blogPost->getTranslated('excerpt', $locale),
            $blogPost->featured_image
        );
        $seo['canonical'] = route('front.blog.show', ['locale' => $locale, 'localizedBlogPost' => $localizedSlug]);

        return view('front.blog.show', compact('blogPost', 'relatedPosts', 'seo'));
    }
}
