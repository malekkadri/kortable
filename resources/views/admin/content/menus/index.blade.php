@extends('layouts.admin')
@section('content')
<div class="flex justify-between mb-4"><h2 class="text-2xl font-semibold">Menus</h2><a class="px-4 py-2 bg-slate-900 text-white rounded" href="{{ route('admin.menus.create') }}">New Menu</a></div>
<form method="GET" class="mb-4 grid md:grid-cols-3 gap-2"><input name="search" value="{{ request('search') }}" class="border rounded px-3 py-2" placeholder="Search menu"><select name="active" class="border rounded px-3 py-2"><option value="">All</option><option value="1" @selected(request('active')==='1')>Active</option><option value="0" @selected(request('active')==='0')>Inactive</option></select><button class="border rounded px-3">Filter</button></form>
<table class="w-full bg-white border rounded text-sm"><tbody>@foreach($menus as $menu)<tr class="border-b"><td class="p-2">{{ $menu->name }}</td><td>{{ $menu->location }}</td><td>{{ $menu->is_active ? 'Active':'Inactive' }}</td><td class="text-right p-2"><a href="{{ route('admin.menus.edit',$menu) }}">Manage items</a><form method="POST" class="inline" action="{{ route('admin.menus.destroy',$menu) }}">@csrf @method('DELETE')<button class="text-red-600 ml-2">Delete</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-4">{{ $menus->links() }}</div>
@endsection
