<?php

namespace App\Http\Controllers\Setting;

use App\Models\Room;
use App\Models\Ward;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_rooms_37')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $wards = Ward::where('status', 1)->get();

        return view('modules.rooms.create', compact('preferences','wards'));
    }

    public function store(Request $request)
    {
        $obj = new Room();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new Room();
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {
          if(!checkPersonPermission('list_rooms_37')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.rooms.index', compact('preferences'));
    }

    public function edit($id)
    {
          if(!checkPersonPermission('update_rooms_37')) {
               return ErrorMessage(403);
        }
        $obj = Room::find($id);
        $preferences = UserPreferences::getPreferences();
        $wards = Ward::where('status', 1)->get();


        return view('modules.rooms.update', compact('preferences', 'obj','wards'));
    }

    public function delete($id = false)
    {
          if(!checkPersonPermission('delete_rooms_37')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Room::find($id);
            return $obj->deleteObj();
        }
    }
}
