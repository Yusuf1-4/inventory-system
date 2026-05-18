<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'role'     => 'required|in:admin,supervisor,operator',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        AuditLogger::log('created', 'User', $user->id,
            "Created user: {$user->name} ({$user->email}) as {$user->role}"
        );

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $oldValues = $user->only(['name', 'email', 'role']);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,supervisor,operator',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        $newValues = ['name' => $data['name'], 'email' => $data['email'], 'role' => $data['role']];
        if (!empty($validated['password'])) {
            $newValues['password'] = '(changed)';
        }
        AuditLogger::log('updated', 'User', $user->id,
            "Updated user: {$user->name} ({$user->email})",
            $oldValues,
            $newValues
        );

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $label = "{$user->name} ({$user->email})";
        $userId = $user->id;
        $user->delete();
        AuditLogger::log('deleted', 'User', $userId, "Deleted user: {$label}");

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
