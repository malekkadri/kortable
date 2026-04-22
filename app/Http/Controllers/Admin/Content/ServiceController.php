<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreServiceRequest;
use App\Http\Requests\Admin\Content\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $services = Service::query()
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('slug', 'like', "%{$search}%")
                    ->orWhere('title->en', 'like', "%{$search}%")
                    ->orWhere('title->fr', 'like', "%{$search}%")
                    ->orWhere('title->ar', 'like', "%{$search}%");
            })
            ->when($request->filled('active'), fn ($q) => $q->where('is_active', (bool) $request->integer('active')))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.content.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.content.services.form', ['service' => new Service()]);
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        foreach (['image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('services', 'public');
            }
        }
        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', __('messages.service_created'));
    }

    public function edit(Service $service): View
    {
        return view('admin.content.services.form', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        } else {
            unset($data['image']);
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', __('messages.service_updated'));
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return back()->with('status', __('messages.service_deleted'));
    }
}
