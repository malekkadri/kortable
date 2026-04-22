@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $project->exists ? 'Edit Project' : 'Create Project' }}</h2>
<form method="POST" enctype="multipart/form-data" action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}" class="space-y-4 bg-white border rounded p-6">
    @csrf
    @if($project->exists) @method('PUT') @endif
    <div class="grid md:grid-cols-3 gap-3">
        <select name="category_id" class="border rounded px-3 py-2">
            <option value="">No category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $project->category_id) == $category->id)>{{ $category->name['en'] ?? $category->slug }}</option>
            @endforeach
        </select>
        <input name="slug" value="{{ old('slug', $project->slug) }}" class="border rounded px-3 py-2" placeholder="slug">
        <input name="client_name" value="{{ old('client_name', $project->client_name) }}" class="border rounded px-3 py-2" placeholder="Client name">
        <input type="date" name="project_date" value="{{ old('project_date', optional($project->project_date)->format('Y-m-d')) }}" class="border rounded px-3 py-2">
        <input name="website_url" value="{{ old('website_url', $project->website_url) }}" class="border rounded px-3 py-2" placeholder="External URL">
        <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" class="border rounded px-3 py-2" placeholder="Order">
        <select name="is_published" class="border rounded px-3 py-2"><option value="1" @selected(old('is_published', $project->is_published) == 1)>Published</option><option value="0" @selected(old('is_published', $project->is_published) === 0)>Draft</option></select>
        <select name="is_featured" class="border rounded px-3 py-2"><option value="1" @selected(old('is_featured', $project->is_featured) == 1)>Featured</option><option value="0" @selected(old('is_featured', $project->is_featured) === 0)>Normal</option></select>
        <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($project->published_at)->format('Y-m-d\TH:i')) }}" class="border rounded px-3 py-2">
    </div>

    <x-admin.translatable-tabs name="title" label="Title" :values="$project->title ?? []" required />
    <x-admin.translatable-tabs name="slug_translations" label="Localized slugs" :values="$project->slug_translations ?? []" />
    <x-admin.translatable-tabs name="short_description" label="Short description" :values="$project->short_description ?? []" type="textarea" rows="3" />
    <x-admin.translatable-tabs name="description" label="Full description" :values="$project->description ?? []" type="textarea" rows="8" />
    <x-admin.translatable-tabs name="seo.meta_title" label="SEO title" :values="$project->seo['meta_title'] ?? []" />
    <x-admin.translatable-tabs name="seo.meta_description" label="SEO description" :values="$project->seo['meta_description'] ?? []" type="textarea" rows="3" />

    <input name="technologies" value="{{ old('technologies', implode(', ', $project->technologies ?? [])) }}" class="border rounded px-3 py-2 w-full" placeholder="Laravel, Vue, Tailwind">

    <div class="grid md:grid-cols-2 gap-3">
        <input type="file" name="featured_image" class="w-full border rounded px-3 py-2">
        <input type="file" name="gallery_uploads[]" multiple class="w-full border rounded px-3 py-2">
    </div>

    @if(!empty($project->gallery))
    <div class="grid md:grid-cols-3 gap-3">
        @foreach($project->gallery as $image)
            <label class="border rounded p-2 text-sm flex items-center gap-2">
                <input type="checkbox" name="existing_gallery[]" value="{{ $image }}" checked>
                <span class="truncate">{{ $image }}</span>
            </label>
        @endforeach
    </div>
    @endif

    <button class="px-4 py-2 bg-slate-900 text-white rounded">Save</button>
</form>
@endsection
