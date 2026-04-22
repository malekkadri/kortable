@extends('layouts.admin')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="text-2xl font-semibold">Pages</h2>
    <a href="{{ route('admin.pages.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded">New Page</a>
</div>
<form method="GET" class="mb-4 grid md:grid-cols-3 gap-2">
    <input name="search" value="{{ request('search') }}" class="border rounded px-3 py-2" placeholder="Search">
    <select name="status" class="border rounded px-3 py-2"><option value="">All statuses</option><option @selected(request('status')==='published') value="published">Published</option><option @selected(request('status')==='draft') value="draft">Draft</option></select>
    <button class="border rounded px-3">Filter</button>
</form>
<table class="w-full bg-white border rounded text-sm"><thead><tr class="border-b"><th class="p-2">Title</th><th>Slug</th><th>Status</th><th></th></tr></thead><tbody>
@foreach($pages as $page)
<tr class="border-b"><td class="p-2">{{ $page->title['en'] ?? '-' }}</td><td>{{ $page->slug }}</td><td>{{ $page->status }}</td><td class="text-right p-2"><a href="{{ route('admin.pages.edit',$page) }}">Edit</a><form method="POST" action="{{ route('admin.pages.destroy',$page) }}" class="inline">@csrf @method('DELETE') <button class="text-red-600 ml-2">Delete</button></form></td></tr>
@endforeach
</tbody></table>
<div class="mt-4">{{ $pages->links() }}</div>
@endsection
