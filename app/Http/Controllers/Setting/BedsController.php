<?php

namespace App\Http\Controllers\Setting;

use App\Models\Bed;
use App\Models\Room;
use App\Models\Ward;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class BedsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_beds_36')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $wards = Ward::where('status', 1)->get();
        $rooms = Room::where('status', 1)->get();

        return view('modules.beds.create', compact('preferences', 'wards', 'rooms'));
    }

    public function store(Request $request)
    {
        $obj = new Bed();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new Bed();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_beds_36')) {
               return ErrorMessage(403);
        }
      
        $preferences = UserPreferences::getPreferences();
        return view('modules.beds.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_beds_36')) {
               return ErrorMessage(403);
        }
        $obj = Bed::find($id);
        $preferences = UserPreferences::getPreferences();
        $wards = Ward::where('status', 1)->get();
        $rooms = Room::where('status', 1)->get();

        return view('modules.beds.update', compact('preferences', 'obj', 'wards', 'rooms'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_beds_36')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Bed::find($id);
            return $obj->deleteObj();
        }
    }

    public function getRooms(Request $request)
    {
        $rooms = Room::where('ward_id', $request->ward_id)
                    ->where('status', 1)
                    ->get();
        return response()->json($rooms);
    }
}
