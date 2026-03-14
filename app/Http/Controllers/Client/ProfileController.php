<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        return view('client.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
        ], [
            'email.unique' => __('messages.profile.email_already_used'),
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', __('messages.profile.updated'));
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => __('messages.profile.current_password_incorrect')]);
        }

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', __('messages.profile.password_updated'));
    }
}
