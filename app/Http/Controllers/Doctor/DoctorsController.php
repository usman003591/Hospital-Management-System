<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class DoctorsController extends Controller
{
    public function create (Request $request) {
          if(!checkPersonPermission('create_doctors_section_5')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        $departments = Department::getActiveDepartments();

        return view('modules.doctors.create',compact('preferences','departments'));
    }

    public function store (Request $request) {

        $obj = new Doctor();
        return $obj->addForm();
    }

    public function update (Request $request) {

        $obj = new Doctor();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
          if(!checkPersonPermission('list_doctors_section_5')) {
               return ErrorMessage(403);
        }
        // $d = Doctor::getAll();

        // $data = $d['data'];
        // $search = $d['search'];
        // $departments = Department::getActiveDepartments();

        // if ($request->ajax()) {
        //     return response()->json([
        //         'status' => 200,
        //         'data' => view('modules.doctors.include.list_partial', compact('data', 'page', 'search', 'departments'))->render(),
        //     ]);
        // }

        $page = 'doctors';
        $preferences = UserPreferences::getPreferences();
        return view('modules.doctors.index', compact('preferences', 'page'));
    }

    public function edit ($id) {
          if(!checkPersonPermission('update_doctors_section_5')) {
               return ErrorMessage(403);
        }

        $obj = Doctor::find($id);
        $departments = Department::getActiveDepartments();

        $preferences = UserPreferences::getPreferences();
        return view('modules.doctors.update',compact('preferences','obj','departments'));

    }

    public function delete($id = false)
    {
          if(!checkPersonPermission('delete_doctors_section_5')) {
               return ErrorMessage(403);
        }
        if ($id) {
             $obj = Doctor::find($id);
             return $obj->deleteObj();
        }
    }
}
