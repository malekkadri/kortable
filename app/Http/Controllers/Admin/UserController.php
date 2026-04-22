<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        return view('admin.users.index', [
            'users' => User::with('roles')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('admin.users.create', [
            'roles' => Role::orderBy('label')->get(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
            'is_admin' => true,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $role = Role::where('name', $request->validated('role'))->firstOrFail();
        $user->roles()->sync([$role->id]);

        return redirect()->route('admin.users.index')->with('status', __('ui.user_created'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', [
            'managedUser' => $user->load('roles'),
            'roles' => Role::orderBy('label')->get(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $payload = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $payload['password'] = Hash::make($request->validated('password'));
        }

        $user->update($payload);

        if ($request->filled('role')) {
            $this->authorize('assignRole', $user);
            $role = Role::where('name', $request->validated('role'))->firstOrFail();
            $user->roles()->sync([$role->id]);
            $user->update(['is_admin' => in_array($role->name, ['super_admin', 'editor'], true)]);
        }

        return redirect()->route('admin.users.index')->with('status', __('ui.user_updated'));
    }
}
