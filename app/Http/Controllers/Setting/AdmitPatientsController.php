<?php

namespace App\Http\Controllers\Setting;

use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\AdmitPatients;

class AdmitPatientsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_admit_patients_18')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $wards = Ward::where('status', 1)->get();
        $rooms = Room::where('status', 1)->get();
        $beds = Bed::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();

        return view('modules.admit_patients.create', compact(
            'preferences',
            'wards',
            'rooms',
            'beds',
            'departments'
        ));
    }

    public function store(Request $request)
    {
        $obj = new AdmitPatients();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new AdmitPatients();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_admit_patients_18')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.admit_patients.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_admit_patients_18')) {
               return ErrorMessage(403);
        }
        $obj = AdmitPatients::find($id);
        $preferences = UserPreferences::getPreferences();
        $wards = Ward::where('status', 1)->get();
        $rooms = Room::where('status', 1)->get();
        $beds = Bed::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();

        return view('modules.admit_patients.update', compact(
            'preferences',
            'obj',
            'wards',
            'rooms',
            'beds',
            'departments'
        ));
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_admit_patients_18')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = AdmitPatients::find($id);
            return $obj->deleteObj();
        }
    }

    // Add dependent dropdown methods for dynamic loading
    public function getRooms(Request $request)
    {
        $rooms = Room::where('ward_id', $request->ward_id)
                    ->where('status', 1)
                    ->get();
        return response()->json($rooms);
    }

    public function getBeds(Request $request)
    {
        $beds = Bed::where('room_id', $request->room_id)
                  ->where('status', 1)
                  ->get();
        return response()->json($beds);
    }
}
