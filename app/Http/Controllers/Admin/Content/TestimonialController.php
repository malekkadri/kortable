<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreTestimonialRequest;
use App\Http\Requests\Admin\Content\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Support\Media\MediaManager;

class TestimonialController extends Controller
{
    public function index(Request $request): View
    {
        $testimonials = Testimonial::query()
            ->when($request->string('search')->toString(), fn ($q, $s) => $q->where('author_name', 'like', "%{$s}%"))
            ->when($request->filled('active'), fn ($q) => $q->where('is_active', (bool) $request->integer('active')))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.content.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.content.testimonials.form', ['testimonial' => new Testimonial()]);
    }

    public function store(StoreTestimonialRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('status', __('messages.testimonial_created'));
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.content.testimonials.form', compact('testimonial'));
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) {
                MediaManager::deletePublic($testimonial->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        } else {
            unset($data['avatar']);
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('status', __('messages.testimonial_updated'));
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->avatar) {
            MediaManager::deletePublic($testimonial->avatar);
        }

        $testimonial->delete();

        return back()->with('status', __('messages.testimonial_deleted'));
    }
}
