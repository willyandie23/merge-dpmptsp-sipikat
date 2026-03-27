<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        return view('backend.pengguna.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'web')->get();
        return view('backend.pengguna.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $roleName = Role::findOrFail($validated['role'])->name;
        $user->syncRoles([$roleName]);

        return redirect()->route('backend.users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        $roles = Role::where('guard_name', 'web')->get();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('backend.pengguna.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $roleName = Role::findOrFail($validated['role'])->name;
        $user->syncRoles([$roleName]);

        return redirect()->route('backend.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('backend.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('backend.users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
