@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $section->exists ? 'Edit Homepage Section' : 'Create Homepage Section' }}</h2>

<form method="POST" enctype="multipart/form-data" action="{{ $section->exists ? route('admin.home-sections.update', $section) : route('admin.home-sections.store') }}" class="space-y-4 bg-white border rounded p-6">
    @csrf
    @if($section->exists)
        @method('PUT')
    @endif

    <div class="grid md:grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-medium mb-1">Section type</label>
            <select name="section_type" class="w-full border rounded px-3 py-2">
                @foreach ($sectionTypes as $key => $definition)
                    <option value="{{ $key }}" @selected(old('section_type', $section->section_type) === $key)>{{ $definition['label'] }}</option>
                @endforeach
            </select>
            @error('section_type')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Section key</label>
            <input name="section_key" value="{{ old('section_key', $section->section_key) }}" class="w-full border rounded px-3 py-2" placeholder="hero_main">
            <p class="text-xs text-slate-500 mt-1">Unique key used internally.</p>
            @error('section_key')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <x-admin.translatable-tabs name="title" label="Title" :values="$section->title ?? []" />
    <x-admin.translatable-tabs name="subtitle" label="Subtitle" :values="$section->subtitle ?? []" />
    <x-admin.translatable-tabs name="content" label="Content" :values="$section->content ?? []" type="textarea" rows="6" />
    <x-admin.translatable-tabs name="cta_label" label="Button label" :values="$section->cta_label ?? []" />

    <div class="grid md:grid-cols-3 gap-3">
        <div>
            <label class="block text-sm font-medium mb-1">Button link</label>
            <input name="cta_link" value="{{ old('cta_link', $section->cta_link) }}" class="w-full border rounded px-3 py-2" placeholder="/projects">
            @error('cta_link')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Sort order</label>
            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $section->sort_order ?? 0) }}" class="w-full border rounded px-3 py-2">
            @error('sort_order')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="is_active" class="w-full border rounded px-3 py-2">
                <option value="1" @selected((string) old('is_active', (int) $section->is_active) === '1')>Active</option>
                <option value="0" @selected((string) old('is_active', (int) $section->is_active) === '0')>Inactive</option>
            </select>
            @error('is_active')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Image</label>
        <input type="file" name="image" class="w-full border rounded px-3 py-2">
        @if ($section->image)
            <p class="text-xs text-slate-500 mt-1">Current: {{ $section->image }}</p>
        @endif
        @error('image')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <button class="px-4 py-2 bg-slate-900 text-white rounded">Save</button>
</form>
@endsection
