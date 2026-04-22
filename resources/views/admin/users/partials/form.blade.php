<div>
    <label class="block text-sm mb-1">{{ __('ui.name') }}</label>
    <input class="w-full border rounded px-3 py-2" name="name" value="{{ old('name', $user?->name) }}" required>
    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm mb-1">{{ __('ui.email') }}</label>
    <input class="w-full border rounded px-3 py-2" name="email" type="email" value="{{ old('email', $user?->email) }}" required>
    @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm mb-1">{{ __('ui.role') }}</label>
    <select class="w-full border rounded px-3 py-2" name="role" required>
        @foreach($roles as $role)
            <option value="{{ $role->name }}" @selected(old('role', $user?->roles->first()?->name) === $role->name)>{{ $role->label }}</option>
        @endforeach
    </select>
    @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm mb-1">{{ __('ui.password') }} {{ $user ? '(' . __('ui.leave_blank_keep') . ')' : '' }}</label>
    <input class="w-full border rounded px-3 py-2" name="password" type="password" {{ $user ? '' : 'required' }}>
    @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm mb-1">{{ __('ui.password_confirmation') }}</label>
    <input class="w-full border rounded px-3 py-2" name="password_confirmation" type="password" {{ $user ? '' : 'required' }}>
</div>

<div>
    <label class="inline-flex items-center gap-2 text-sm">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user?->is_active ?? true))>
        {{ __('ui.active') }}
    </label>
</div>
