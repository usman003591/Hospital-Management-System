<?php

namespace App\Http\Controllers\Setting;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class HospitalsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_hospitals_28')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.hospitals.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new Hospital();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new Hospital();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_hospitals_28')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.hospitals.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_hospitals_28')) {
               return ErrorMessage(403);
        }
        $obj = Hospital::find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.hospitals.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_hospitals_28')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Hospital::find($id);
            return $obj->deleteObj();
        }
    }

    // public function fetchHospitalDoctors (Request $request) {

    //     $auth_user = auth()->user();
    //     $preferences = UserPreferences::getPreferences();
    //     $hospital_id = $request->hospital_id;
    //     $doctors = User::getHospitalDoctors($hospital_id);

    //     // if ($request->ajax()) {
    //         return response()->json([
    //             'status' => 200,
    //             'doctors' => $doctors,
    //             // 'html' => view('layouts.partials.doctors_listing_partial', compact('auth_user','preferences','doctors'))->render(),
    //         ]);
    //     // }
    // }

    public function fetchHospitalDoctors($hospital_id) {
        $doctors = Doctor::getHospitalDoctors($hospital_id);

        return response()->json([
            'status' => 200,
            'doctors' => $doctors,
        ]);
    }


}
