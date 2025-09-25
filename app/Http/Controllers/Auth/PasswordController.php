<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password and log them out.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'current_password.required' => 'Current password is required',
            'current_password.current_password' => 'Current password is incorrect',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match'
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Flash success message before logging out
        session()->flash('success', 'Password updated successfully. Please log in with your new password.');

        // Logout the user from all sessions
        Auth::logoutCurrentDevice();

        // Optional: If you want to logout from all devices/sessions
        // Auth::logoutOtherDevices($validated['current_password']);

        return redirect()->route('login')->with('status', 'Password updated');
    }
}
