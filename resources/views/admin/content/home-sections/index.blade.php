@extends('layouts.admin')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="text-2xl font-semibold">Homepage Sections</h2>
    <a class="px-4 py-2 bg-slate-900 text-white rounded" href="{{ route('admin.home-sections.create') }}">New Section</a>
</div>

<form method="GET" class="mb-4 grid md:grid-cols-3 gap-2">
    <input name="search" value="{{ request('search') }}" class="border rounded px-3 py-2" placeholder="Search by key/title">
    <select name="active" class="border rounded px-3 py-2">
        <option value="">All</option>
        <option value="1" @selected(request('active') === '1')>Active</option>
        <option value="0" @selected(request('active') === '0')>Inactive</option>
    </select>
    <button class="border rounded px-3">Filter</button>
</form>

<table class="w-full bg-white border rounded text-sm">
    <thead>
        <tr class="text-left border-b bg-slate-50">
            <th class="p-2">Type</th>
            <th class="p-2">Key</th>
            <th class="p-2">Title (EN)</th>
            <th class="p-2">Order</th>
            <th class="p-2">Status</th>
            <th class="p-2 text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sections as $section)
            <tr class="border-b">
                <td class="p-2">{{ $sectionTypes[$section->section_type]['label'] ?? str($section->section_type)->replace('_', ' ')->title() }}</td>
                <td class="p-2 font-mono text-xs">{{ $section->section_key }}</td>
                <td class="p-2">{{ $section->title['en'] ?? '-' }}</td>
                <td class="p-2">{{ $section->sort_order }}</td>
                <td class="p-2">{{ $section->is_active ? 'Active' : 'Inactive' }}</td>
                <td class="text-right p-2">
                    <a href="{{ route('admin.home-sections.edit', $section) }}">Edit</a>
                    <form method="POST" class="inline" action="{{ route('admin.home-sections.destroy', $section) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-slate-500">No homepage sections yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $sections->links() }}</div>
@endsection
