<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StorePageRequest;
use App\Http\Requests\Admin\Content\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $pages = Page::query()
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('slug', 'like', "%{$search}%")
                    ->orWhere('title->en', 'like', "%{$search}%")
                    ->orWhere('title->fr', 'like', "%{$search}%")
                    ->orWhere('title->ar', 'like', "%{$search}%");
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.content.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.content.pages.form', ['page' => new Page()]);
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['featured_image'] = $request->hasFile('featured_image')
            ? $request->file('featured_image')->store('pages', 'public')
            : null;

        if ($request->hasFile('seo_og_image')) {
            $seo = $data['seo'] ?? [];
            $seo['og_image'] = $request->file('seo_og_image')->store('pages/seo', 'public');
            $data['seo'] = $seo;
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('status', __('messages.page_created'));
    }

    public function edit(Page $page): View
    {
        return view('admin.content.pages.form', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        } else {
            unset($data['featured_image']);
        }

        if ($request->hasFile('seo_og_image')) {
            if (! empty($page->seo['og_image'])) {
                Storage::disk('public')->delete($page->seo['og_image']);
            }
            $seo = $data['seo'] ?? $page->seo ?? [];
            $seo['og_image'] = $request->file('seo_og_image')->store('pages/seo', 'public');
            $data['seo'] = $seo;
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('status', __('messages.page_updated'));
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        if (! empty($page->seo['og_image'])) {
            Storage::disk('public')->delete($page->seo['og_image']);
        }

        $page->delete();

        return back()->with('status', __('messages.page_deleted'));
    }
}
