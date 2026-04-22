@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $page->exists ? 'Edit Page' : 'Create Page' }}</h2>
<form method="POST" enctype="multipart/form-data" action="{{ $page->exists ? route('admin.pages.update',$page) : route('admin.pages.store') }}" class="space-y-4 bg-white border rounded p-6">
@csrf
@if($page->exists) @method('PUT') @endif
<div class="grid md:grid-cols-3 gap-3">
<input name="slug" value="{{ old('slug',$page->slug) }}" placeholder="slug" class="border rounded px-3 py-2">
<select name="status" class="border rounded px-3 py-2"><option value="published" @selected(old('status',$page->status)==='published')>Published</option><option value="draft" @selected(old('status',$page->status)==='draft')>Draft</option><option value="archived" @selected(old('status',$page->status)==='archived')>Archived</option></select>
<select name="is_active" class="border rounded px-3 py-2"><option value="1" @selected(old('is_active',$page->is_active) == 1)>Active</option><option value="0" @selected(old('is_active',$page->is_active) === 0)>Inactive</option></select>
<input name="template" value="{{ old('template',$page->template ?? 'default') }}" class="border rounded px-3 py-2" placeholder="template">
<input name="sort_order" type="number" value="{{ old('sort_order',$page->sort_order ?? 0) }}" class="border rounded px-3 py-2" placeholder="order">
<input name="featured_image" type="file" class="border rounded px-3 py-2">
</div>
<x-admin.translatable-tabs name="title" label="Title" :values="$page->title ?? []" required />
<x-admin.translatable-tabs name="slug_translations" label="Slug translations" :values="$page->slug_translations ?? []" />
<x-admin.translatable-tabs name="excerpt" label="Excerpt" :values="$page->excerpt ?? []" type="textarea" />
<x-admin.translatable-tabs name="content" label="Content" :values="$page->content ?? ($page->body ?? [])" type="textarea" rows="6" />
<x-admin.translatable-tabs name="seo.meta_title" label="SEO title" :values="$page->seo['meta_title'] ?? []" />
<x-admin.translatable-tabs name="seo.meta_description" label="Meta description" :values="$page->seo['meta_description'] ?? []" type="textarea" rows="3" />
<div class="grid md:grid-cols-2 gap-3">
<input name="seo[og_image]" value="{{ old('seo.og_image',$page->seo['og_image'] ?? '') }}" placeholder="OG image path" class="w-full border rounded px-3 py-2">
<input name="seo_og_image" type="file" class="w-full border rounded px-3 py-2">
</div>
<button class="px-4 py-2 bg-slate-900 text-white rounded">Save</button>
</form>
@endsection
