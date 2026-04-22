@extends('layouts.admin')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="text-2xl font-semibold">Projects</h2>
    <a class="px-4 py-2 bg-slate-900 text-white rounded" href="{{ route('admin.projects.create') }}">New Project</a>
</div>
<form method="GET" class="mb-4 grid md:grid-cols-7 gap-2">
    <input name="search" value="{{ request('search') }}" class="border rounded px-3 py-2" placeholder="Search">
    <select name="category_id" class="border rounded px-3 py-2"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name['en'] ?? $category->slug }}</option>@endforeach</select>
    <select name="published" class="border rounded px-3 py-2"><option value="">Published + draft</option><option value="1" @selected(request('published')==='1')>Published</option><option value="0" @selected(request('published')==='0')>Draft</option></select>
    <select name="featured" class="border rounded px-3 py-2"><option value="">Featured + normal</option><option value="1" @selected(request('featured')==='1')>Featured</option><option value="0" @selected(request('featured')==='0')>Normal</option></select>
    <select name="sort" class="border rounded px-3 py-2"><option value="sort_order" @selected(request('sort')==='sort_order')>Sort order</option><option value="project_date" @selected(request('sort')==='project_date')>Project date</option><option value="created_at" @selected(request('sort')==='created_at')>Created</option></select>
    <select name="direction" class="border rounded px-3 py-2"><option value="asc" @selected(request('direction','asc')==='asc')>ASC</option><option value="desc" @selected(request('direction')==='desc')>DESC</option></select>
    <button class="border rounded px-3">Apply</button>
</form>
<table class="w-full bg-white border rounded text-sm">
    <tbody>
    @foreach($projects as $project)
        <tr class="border-b">
            <td class="p-2">{{ $project->title['en'] ?? '-' }}</td>
            <td>{{ $project->category->name['en'] ?? '-' }}</td>
            <td>{{ $project->is_published ? 'Published' : 'Draft' }}</td>
            <td>{{ $project->is_featured ? 'Featured' : 'Normal' }}</td>
            <td>{{ $project->sort_order }}</td>
            <td class="text-right p-2">
                <a href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                <form method="POST" class="inline" action="{{ route('admin.projects.destroy', $project) }}">@csrf @method('DELETE')<button class="text-red-600 ml-2">Delete</button></form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $projects->links() }}</div>
@endsection
