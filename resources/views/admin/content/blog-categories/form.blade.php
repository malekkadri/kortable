@extends('layouts.admin')
@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $blogCategory->exists ? 'Edit Blog Category' : 'Create Blog Category' }}</h2>
<form method="POST" action="{{ $blogCategory->exists ? route('admin.blog-categories.update', $blogCategory) : route('admin.blog-categories.store') }}" class="space-y-4 bg-white border rounded p-6">
    @csrf
    @if($blogCategory->exists) @method('PUT') @endif

    <div class="grid md:grid-cols-3 gap-3">
        <input name="slug" value="{{ old('slug', $blogCategory->slug) }}" class="border rounded px-3 py-2" placeholder="slug">
        <input type="number" name="sort_order" value="{{ old('sort_order', $blogCategory->sort_order ?? 0) }}" class="border rounded px-3 py-2" placeholder="Order">
        <select name="is_active" class="border rounded px-3 py-2"><option value="1" @selected(old('is_active', $blogCategory->is_active) == 1)>Active</option><option value="0" @selected(old('is_active', $blogCategory->is_active) === 0)>Inactive</option></select>
    </div>

    <x-admin.translatable-tabs name="name" label="Name" :values="$blogCategory->name ?? []" required />
    <x-admin.translatable-tabs name="description" label="Description" :values="$blogCategory->description ?? []" type="textarea" rows="4" />

    <button class="px-4 py-2 bg-slate-900 text-white rounded">Save</button>
</form>
@endsection
