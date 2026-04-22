@extends('layouts.admin')
@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $service->exists ? 'Edit Service' : 'Create Service' }}</h2>
<form method="POST" enctype="multipart/form-data" action="{{ $service->exists ? route('admin.services.update',$service) : route('admin.services.store') }}" class="space-y-4 bg-white border rounded p-6">@csrf @if($service->exists) @method('PUT') @endif
<div class="grid md:grid-cols-4 gap-3">
<input name="slug" value="{{ old('slug',$service->slug) }}" class="border rounded px-3 py-2" placeholder="slug">
<input name="icon" value="{{ old('icon',$service->icon) }}" class="border rounded px-3 py-2" placeholder="icon class">
<input type="number" name="sort_order" value="{{ old('sort_order',$service->sort_order ?? 0) }}" class="border rounded px-3 py-2">
<select name="is_active" class="border rounded px-3 py-2"><option value="1" @selected(old('is_active',$service->is_active) == 1)>Active</option><option value="0" @selected(old('is_active',$service->is_active) === 0)>Inactive</option></select>
</div>
<input type="file" name="image" class="w-full border rounded px-3 py-2">
<x-admin.translatable-tabs name="title" label="Title" :values="$service->title ?? []" required />
<x-admin.translatable-tabs name="short_description" label="Short description" :values="$service->short_description ?? []" type="textarea" />
<x-admin.translatable-tabs name="description" label="Description" :values="$service->description ?? []" type="textarea" rows="6" />
<button class="px-4 py-2 bg-slate-900 text-white rounded">Save</button></form>
@endsection
