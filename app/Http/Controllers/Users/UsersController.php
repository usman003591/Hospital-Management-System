<?php

namespace App\Http\Controllers\Users;

use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function create (Request $request) {
        if(!checkPersonPermission('create_users_3')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        $roles = Role::getActiveRoles();
        $hospitals = Hospital::getActiveHospitals();
        $departments = Department::getActiveDepartments();

        return view('modules.users.create',compact('preferences','roles','hospitals', 'departments'));
    }

    public function store (Request $request) {

        $obj = new User();
        return $obj->createForm();
    }

    public function update (Request $request) {

        $obj = new User();
        return $obj->updateForm();
    }

    public function index (Request $request) {

         if(!checkPersonPermission('list_users_3')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.users.index',compact('preferences'));
    }

    public function edit ($id) {
        if(!checkPersonPermission('update_users_3')) {
               return ErrorMessage(403);
        }

        $user = User::find($id);
        $roles = Role::where('status',1)->get();
        $hospitals = Hospital::getActiveHospitals();
        $departments = Department::getActiveDepartments();
        $doctor = Doctor::getByUserId($id);

        $preferences = UserPreferences::getPreferences();
        $specific_preferences = UserPreferences::getPreferencesOfSpecificUser($id);

        return view('modules.users.update',compact('preferences','user','roles','hospitals','specific_preferences', 'departments', 'doctor'));

    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_users_3')) {
               return ErrorMessage(403);
        }
        if ($id) {
             $obj = User::find($id);
             return $obj->deleteObj();
        }
    }
}
