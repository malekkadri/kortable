@extends('layouts.admin')
@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $blogPost->exists ? 'Edit Blog Post' : 'Create Blog Post' }}</h2>
<form method="POST" enctype="multipart/form-data" action="{{ $blogPost->exists ? route('admin.blog-posts.update', $blogPost) : route('admin.blog-posts.store') }}" class="space-y-4 bg-white border rounded p-6">
    @csrf
    @if($blogPost->exists) @method('PUT') @endif

    <div class="grid md:grid-cols-3 gap-3">
        <select name="category_id" class="border rounded px-3 py-2"><option value="">No category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $blogPost->category_id) == $category->id)>{{ $category->name['en'] ?? $category->slug }}</option>@endforeach</select>
        <input name="slug" value="{{ old('slug', $blogPost->slug) }}" class="border rounded px-3 py-2" placeholder="slug">
        <select name="is_published" class="border rounded px-3 py-2"><option value="1" @selected(old('is_published', $blogPost->is_published) == 1)>Published</option><option value="0" @selected(old('is_published', $blogPost->is_published) === 0)>Draft</option></select>
        <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($blogPost->published_at)->format('Y-m-d\TH:i')) }}" class="border rounded px-3 py-2">
        <input type="file" name="featured_image" class="w-full border rounded px-3 py-2">
        <input type="file" name="seo_og_image" class="w-full border rounded px-3 py-2">
    </div>

    <x-admin.translatable-tabs name="title" label="Title" :values="$blogPost->title ?? []" required />
    <x-admin.translatable-tabs name="slug_translations" label="Localized slugs" :values="$blogPost->slug_translations ?? []" />
    <x-admin.translatable-tabs name="excerpt" label="Excerpt" :values="$blogPost->excerpt ?? []" type="textarea" rows="3" />
    <x-admin.translatable-tabs name="content" label="Content" :values="$blogPost->content ?? []" type="textarea" rows="10" />
    <x-admin.translatable-tabs name="seo.meta_title" label="SEO title" :values="$blogPost->seo['meta_title'] ?? []" />
    <x-admin.translatable-tabs name="seo.meta_description" label="SEO description" :values="$blogPost->seo['meta_description'] ?? []" type="textarea" rows="3" />
    <input name="seo[og_image]" value="{{ old('seo.og_image', $blogPost->seo['og_image'] ?? '') }}" class="border rounded px-3 py-2 w-full" placeholder="OG image path">

    <button class="px-4 py-2 bg-slate-900 text-white rounded">Save</button>
</form>
@endsection
