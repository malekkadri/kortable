@extends('layouts.admin')
@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $testimonial->exists ? 'Edit Testimonial' : 'Create Testimonial' }}</h2>
<form method="POST" enctype="multipart/form-data" action="{{ $testimonial->exists ? route('admin.testimonials.update',$testimonial) : route('admin.testimonials.store') }}" class="space-y-4 bg-white border rounded p-6">@csrf @if($testimonial->exists) @method('PUT') @endif
<div class="grid md:grid-cols-5 gap-3"><input name="author_name" value="{{ old('author_name',$testimonial->author_name) }}" class="border rounded px-3 py-2" placeholder="author"><input name="company" value="{{ old('company',$testimonial->company) }}" class="border rounded px-3 py-2" placeholder="company"><input type="number" min="1" max="5" name="rating" value="{{ old('rating',$testimonial->rating ?? 5) }}" class="border rounded px-3 py-2"><input type="number" name="sort_order" value="{{ old('sort_order',$testimonial->sort_order ?? 0) }}" class="border rounded px-3 py-2"><select name="is_active" class="border rounded px-3 py-2"><option value="1" @selected(old('is_active',$testimonial->is_active) == 1)>Active</option><option value="0" @selected(old('is_active',$testimonial->is_active) === 0)>Inactive</option></select></div>
<input type="file" name="avatar" class="w-full border rounded px-3 py-2">
<x-admin.translatable-tabs name="author_role" label="Author role" :values="$testimonial->author_role ?? []" />
<x-admin.translatable-tabs name="content" label="Testimonial content" :values="$testimonial->content ?? []" type="textarea" rows="5" required />
<button class="px-4 py-2 bg-slate-900 text-white rounded">Save</button></form>
@endsection
