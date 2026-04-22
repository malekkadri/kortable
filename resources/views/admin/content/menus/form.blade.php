@extends('layouts.admin')
@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $menu->exists ? 'Edit Menu' : 'Create Menu' }}</h2>
<form method="POST" action="{{ $menu->exists ? route('admin.menus.update',$menu) : route('admin.menus.store') }}" class="space-y-4 bg-white border rounded p-6">@csrf @if($menu->exists) @method('PUT') @endif
<div class="grid md:grid-cols-3 gap-3"><input name="name" value="{{ old('name',$menu->name) }}" placeholder="Name" class="border rounded px-3 py-2"><input name="location" value="{{ old('location',$menu->location) }}" placeholder="Location (header/footer)" class="border rounded px-3 py-2"><select name="is_active" class="border rounded px-3 py-2"><option value="1" @selected(old('is_active',$menu->is_active) == 1)>Active</option><option value="0" @selected(old('is_active',$menu->is_active) === 0)>Inactive</option></select></div>
<button class="px-4 py-2 bg-slate-900 text-white rounded">Save menu</button></form>

@if($menu->exists)
<div class="mt-8 bg-white border rounded p-6">
    <h3 class="font-semibold mb-3">Add menu item</h3>
    <form method="POST" action="{{ route('admin.menus.items.store', $menu) }}" class="space-y-3">@csrf
        <div class="grid md:grid-cols-4 gap-2">
            <select name="type" class="border rounded px-3 py-2"><option value="page">Internal page</option><option value="custom">Custom URL</option></select>
            <select name="linked_page_id" class="border rounded px-3 py-2"><option value="">Select page</option>@foreach($pages as $page)<option value="{{ $page->id }}">{{ $page->title['en'] ?? $page->slug }}</option>@endforeach</select>
            <input name="custom_url" placeholder="https://... or /contact" class="border rounded px-3 py-2">
            <select name="parent_id" class="border rounded px-3 py-2"><option value="">Top level</option>@foreach($menu->items as $item)<option value="{{ $item->id }}">{{ $item->label['en'] ?? 'Item' }}</option>@endforeach</select>
            <input name="sort_order" type="number" value="0" class="border rounded px-3 py-2">
            <select name="is_active" class="border rounded px-3 py-2"><option value="1">Active</option><option value="0">Inactive</option></select>
        </div>
        <x-admin.translatable-tabs name="label" label="Label" :values="[]" required />
        <button class="px-4 py-2 bg-slate-900 text-white rounded">Add item</button>
    </form>
</div>

<div class="mt-6 bg-white border rounded p-6">
    <h3 class="font-semibold mb-3">Existing items</h3>
    @forelse($items as $item)
        <div class="border rounded p-3 mb-2">
            <div class="flex justify-between"><p>{{ $item->label['en'] ?? 'Item' }} <span class="text-xs text-slate-500">({{ $item->type }})</span></p>
                <form method="POST" action="{{ route('admin.menus.items.destroy', [$menu, $item]) }}">@csrf @method('DELETE')<button class="text-red-600 text-sm">Delete</button></form>
            </div>
            @if($item->children->isNotEmpty())
                <ul class="mt-2 ml-4 list-disc text-sm text-slate-600">@foreach($item->children as $child)<li>{{ $child->label['en'] ?? 'Item' }}</li>@endforeach</ul>
            @endif
        </div>
    @empty
        <p class="text-sm text-slate-500">No items yet.</p>
    @endforelse
</div>
@endif
@endsection
