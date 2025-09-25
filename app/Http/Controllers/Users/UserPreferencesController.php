<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class UserPreferencesController extends Controller
{
    public function change_preferences (Request $request) {
        if(!checkPersonPermission('change_user_preferences_section_52')) {
               return ErrorMessage(403);
        }
        $obj = new UserPreferences();
        return $obj->updatePreferences();
    }
}
