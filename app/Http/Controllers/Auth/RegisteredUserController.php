<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view with user list.
     */
    public function create(): View
    {
        return view('auth.register', [
            'users' => User::all(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'unique:users,nip'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,kesiswaan,guru bk,kepala sekolah,guru pembina,wali kelas'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        return redirect()->route('dashboard.register')->with('success', 'User registered successfully.');
    }

    /**
     * Update user details.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        Log::info("PUT request received for user ID: {$id}");
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'unique:users,nip,' . $user->id],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,kesiswaan,guru bk,kepala sekolah,guru pembina,wali kelas'],
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'nip' => $request->nip,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'role' => $request->role,
            ]);
            Log::info("User {$id} updated successfully.");
        } catch (\Exception $e) {
            Log::error("Error updating user {$id}: {$e->getMessage()}");
            return redirect()
                ->route('dashboard.register')
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.register')->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);

            if ($user->id === Auth::id()) {
                return redirect()->route('dashboard.register')->with('error', 'Cannot delete your own account.');
            }

            $user->delete();

            return redirect()->route('dashboard.register')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Error deleting user {$id}: {$e->getMessage()}");
            return redirect()
                ->route('dashboard.register')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}