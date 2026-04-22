@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">{{ __('ui.planned_modules') }}</h2>
    <div class="bg-white border rounded-xl p-6">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($modules as $module)
                <li>{{ str($module)->replace('_', ' ')->title() }}</li>
            @endforeach
        </ul>
    </div>
@endsection
