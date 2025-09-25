<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hospital;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
         if(!checkPersonPermission('overview_profile_section_53')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $user = $request->user();

        return view('profile.edit', ['user' => $user,'preferences' => $preferences]);
    }


    public function profile_settings (Request $request) {


       if(!checkPersonPermission('change_profile_detail_profile_section_53')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $user = $request->user();

        return view('profile.profile_settings', ['user' => $user,'preferences' => $preferences]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $obj = new User();
        return $obj->addForm();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function fetchUserHospitals (Request $request) {

        $auth_user = auth()->user();
        $preferences = UserPreferences::getPreferences();
        $hospitals = Hospital::getActiveHospitals();

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'html' => view('layouts.partials.hospital_listing_partial', compact('auth_user','preferences','hospitals'))->render(),
            ]);
        }
    }


}
