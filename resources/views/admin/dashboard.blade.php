@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">{{ __('ui.dashboard') }}</h2>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.total_projects') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['total_projects'] }}</p>
        </div>
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.featured_projects') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['featured_projects'] }}</p>
        </div>
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.published_pages') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['published_pages'] }}</p>
        </div>
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.active_services') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['active_services'] }}</p>
        </div>
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.unread_messages') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['unread_messages'] }}</p>
        </div>
    </div>

    <div class="grid gap-4 mt-6 xl:grid-cols-3">
        <div class="bg-white border rounded-xl p-5">
            <h3 class="text-base font-semibold mb-3">{{ __('ui.quick_actions') }}</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.projects.create') }}" class="px-3 py-2 text-sm rounded bg-slate-900 text-white">{{ __('ui.new_project') }}</a>
                <a href="{{ route('admin.pages.create') }}" class="px-3 py-2 text-sm rounded bg-slate-900 text-white">{{ __('ui.new_page') }}</a>
                <a href="{{ route('admin.services.create') }}" class="px-3 py-2 text-sm rounded bg-slate-900 text-white">{{ __('ui.new_service') }}</a>
            </div>
        </div>

        <div class="bg-white border rounded-xl p-5 xl:col-span-2">
            <h3 class="text-base font-semibold mb-3">{{ __('ui.latest_contact_messages') }}</h3>
            <div class="space-y-3">
                @forelse($latestMessages as $message)
                    <div class="flex items-start justify-between gap-4 border-b pb-3 last:border-b-0 last:pb-0">
                        <div>
                            <p class="text-sm font-medium text-slate-800">{{ $message->name }} · {{ $message->subject ?: __('ui.no_subject') }}</p>
                            <p class="text-xs text-slate-500">{{ $message->email }}</p>
                        </div>
                        <a class="text-sm underline" href="{{ route('admin.contact-messages.show', $message) }}">{{ __('ui.view') }}</a>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">{{ __('ui.no_content_available') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid gap-4 mt-6 xl:grid-cols-2">
        <div class="bg-white border rounded-xl p-5">
            <h3 class="text-base font-semibold mb-3">{{ __('ui.latest_published_projects') }}</h3>
            <div class="space-y-3">
                @forelse($latestPublishedProjects as $project)
                    <div class="flex items-start justify-between gap-4 border-b pb-3 last:border-b-0 last:pb-0">
                        <div>
                            <p class="text-sm font-medium text-slate-800">{{ $project->title['en'] ?? $project->slug }}</p>
                            <p class="text-xs text-slate-500">{{ $project->published_at?->format('Y-m-d H:i') ?? $project->created_at?->format('Y-m-d H:i') }}</p>
                        </div>
                        <a class="text-sm underline" href="{{ route('admin.projects.edit', $project) }}">{{ __('ui.edit') }}</a>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">{{ __('ui.no_content_available') }}</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white border rounded-xl p-5">
            <h3 class="text-base font-semibold mb-3">{{ __('ui.recent_activity') }}</h3>
            <div class="space-y-3">
                @forelse($recentActivity as $activity)
                    <div class="border-b pb-3 last:border-b-0 last:pb-0">
                        <p class="text-sm text-slate-800">
                            <span class="font-medium">{{ ucfirst($activity['type']) }}</span>
                            {{ $activity['action'] }}: {{ $activity['title'] }}
                        </p>
                        <p class="text-xs text-slate-500">{{ $activity['timestamp']?->format('Y-m-d H:i') }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">{{ __('ui.no_content_available') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
