@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.contact-messages.index') }}" class="text-sm underline">&larr; {{ __('ui.contact_messages') }}</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-4">
        <article class="lg:col-span-2 bg-white border rounded p-6 space-y-4">
            <h2 class="text-xl font-semibold">{{ $message->subject }}</h2>
            <p><strong>{{ __('ui.name') }}:</strong> {{ $message->name }}</p>
            <p><strong>{{ __('ui.email') }}:</strong> {{ $message->email }}</p>
            @if($message->phone)<p><strong>{{ __('ui.phone') }}:</strong> {{ $message->phone }}</p>@endif
            <p><strong>{{ __('ui.created_at') }}:</strong> {{ $message->created_at?->format('Y-m-d H:i') }}</p>
            <p><strong>{{ __('ui.status') }}:</strong> {{ __('ui.contact_status_'.$message->status) }}</p>
            <hr>
            <p class="whitespace-pre-line">{{ $message->message }}</p>
        </article>

        <aside class="bg-white border rounded p-6">
            <form method="POST" action="{{ route('admin.contact-messages.update', $message) }}" class="space-y-3">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm mb-1">{{ __('ui.status') }}</label>
                    <select name="status" class="w-full border rounded px-3 py-2">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $message->status) === $status)>{{ __('ui.contact_status_'.$status) }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm mb-1">{{ __('ui.internal_notes') }}</label>
                    <textarea name="notes" rows="7" class="w-full border rounded px-3 py-2">{{ old('notes', $message->notes) }}</textarea>
                    @error('notes')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <button class="px-4 py-2 bg-slate-900 text-white rounded">{{ __('ui.save_changes') }}</button>
            </form>
        </aside>
    </div>
@endsection
