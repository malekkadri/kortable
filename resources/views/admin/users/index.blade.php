@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-semibold">{{ __('ui.users') }}</h2>
        <a href="{{ route('admin.users.create') }}" class="bg-slate-900 text-white rounded px-4 py-2 text-sm">{{ __('ui.create_user') }}</a>
    </div>

    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left">{{ __('ui.name') }}</th>
                <th class="px-4 py-3 text-left">{{ __('ui.email') }}</th>
                <th class="px-4 py-3 text-left">{{ __('ui.role') }}</th>
                <th class="px-4 py-3 text-left">{{ __('ui.status') }}</th>
                <th class="px-4 py-3 text-left">{{ __('ui.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">{{ $user->roles->pluck('label')->join(', ') ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $user->is_active ? __('ui.active') : __('ui.inactive') }}</td>
                    <td class="px-4 py-3">
                        <a class="underline" href="{{ route('admin.users.edit', $user) }}">{{ __('ui.edit') }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
