<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreHomeSectionRequest;
use App\Http\Requests\Admin\Content\UpdateHomeSectionRequest;
use App\Models\HomeSection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    public function index(Request $request): View
    {
        $sections = HomeSection::query()
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('section_key', 'like', "%{$search}%")
                    ->orWhere('title->en', 'like', "%{$search}%")
                    ->orWhere('title->fr', 'like', "%{$search}%")
                    ->orWhere('title->ar', 'like', "%{$search}%");
            })
            ->when($request->filled('active'), fn ($q) => $q->where('is_active', (bool) $request->integer('active')))
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.content.home-sections.index', [
            'sections' => $sections,
            'sectionTypes' => HomeSection::sectionTypes(),
        ]);
    }

    public function create(): View
    {
        return view('admin.content.home-sections.form', [
            'section' => new HomeSection(['is_active' => true, 'sort_order' => 0]),
            'sectionTypes' => HomeSection::sectionTypes(),
        ]);
    }

    public function store(StoreHomeSectionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('home-sections', 'public');
        }

        HomeSection::create($data);

        return redirect()->route('admin.home-sections.index')->with('status', __('messages.home_section_created'));
    }

    public function edit(HomeSection $homeSection): View
    {
        return view('admin.content.home-sections.form', [
            'section' => $homeSection,
            'sectionTypes' => HomeSection::sectionTypes(),
        ]);
    }

    public function update(UpdateHomeSectionRequest $request, HomeSection $homeSection): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($homeSection->image) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $data['image'] = $request->file('image')->store('home-sections', 'public');
        } else {
            unset($data['image']);
        }

        $homeSection->update($data);

        return redirect()->route('admin.home-sections.index')->with('status', __('messages.home_section_updated'));
    }

    public function destroy(HomeSection $homeSection): RedirectResponse
    {
        if ($homeSection->image) {
            Storage::disk('public')->delete($homeSection->image);
        }

        $homeSection->delete();

        return back()->with('status', __('messages.home_section_deleted'));
    }
}
