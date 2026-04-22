@extends('layouts.admin')
@section('content')
<div class="flex justify-between mb-4"><h2 class="text-2xl font-semibold">Services</h2><a class="px-4 py-2 bg-slate-900 text-white rounded" href="{{ route('admin.services.create') }}">New Service</a></div>
<form method="GET" class="mb-4 grid md:grid-cols-3 gap-2"><input name="search" value="{{ request('search') }}" class="border rounded px-3 py-2" placeholder="Search"><select name="active" class="border rounded px-3 py-2"><option value="">All</option><option value="1" @selected(request('active')==='1')>Active</option><option value="0" @selected(request('active')==='0')>Inactive</option></select><button class="border rounded px-3">Filter</button></form>
<table class="w-full bg-white border rounded text-sm"><tbody>@foreach($services as $service)<tr class="border-b"><td class="p-2">{{ $service->title['en'] ?? '-' }}</td><td>{{ $service->sort_order }}</td><td>{{ $service->is_active ? 'Active':'Inactive' }}</td><td class="text-right p-2"><a href="{{ route('admin.services.edit',$service) }}">Edit</a><form method="POST" class="inline" action="{{ route('admin.services.destroy',$service) }}">@csrf @method('DELETE')<button class="text-red-600 ml-2">Delete</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-4">{{ $services->links() }}</div>
@endsection
