@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">{{ __('ui.create_user') }}</h2>

    <form class="space-y-4 bg-white border rounded-xl p-6" method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        @include('admin.users.partials.form', ['user' => null])
        <button class="bg-slate-900 text-white rounded px-4 py-2" type="submit">{{ __('ui.create_user') }}</button>
    </form>
@endsection
