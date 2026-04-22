@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">{{ __('ui.contact_messages') }}</h2>

    <form method="GET" class="mb-4 grid md:grid-cols-3 gap-3 bg-white border rounded p-4">
        <input name="q" value="{{ request('q') }}" class="border rounded px-3 py-2" placeholder="{{ __('ui.search') }}">
        <select name="status" class="border rounded px-3 py-2">
            <option value="">{{ __('ui.all_statuses') }}</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ __('ui.contact_status_'.$status) }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2 bg-slate-900 text-white rounded">{{ __('ui.filter') }}</button>
    </form>

    <div class="bg-white border rounded overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-2 text-left">{{ __('ui.name') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('ui.email') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('ui.subject') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('ui.status') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('ui.created_at') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('ui.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $msg->name }}</td>
                        <td class="px-4 py-3">{{ $msg->email }}</td>
                        <td class="px-4 py-3">{{ $msg->subject }}</td>
                        <td class="px-4 py-3">{{ __('ui.contact_status_'.$msg->status) }}</td>
                        <td class="px-4 py-3">{{ $msg->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3"><a class="text-slate-700 underline" href="{{ route('admin.contact-messages.show', $msg) }}">{{ __('ui.view') }}</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-slate-500">{{ __('ui.no_content_available') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $messages->links() }}</div>
@endsection
