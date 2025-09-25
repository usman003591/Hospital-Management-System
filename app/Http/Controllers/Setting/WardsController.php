<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Ward;

class WardsController extends Controller
{
    public function create(Request $request)
    {
          if(!checkPersonPermission('create_wards_35')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $floors = Floor::where('status', 1)->get();
        return view('modules.wards.create', compact('preferences','floors'));
    }

    public function store(Request $request)
    {
        $obj = new Ward();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new Ward();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_wards_35')) {
               return ErrorMessage(403);
        }
    
        $preferences = UserPreferences::getPreferences();
        return view('modules.wards.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_wards_35')) {
               return ErrorMessage(403);
        }
        $obj = Ward::find($id);
        $preferences = UserPreferences::getPreferences();
        $floors = Floor::where('status', 1)->get();


        return view('modules.wards.update', compact('preferences', 'obj','floors'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_wards_35')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Ward::find($id);
            return $obj->deleteObj();
        }
    }
}
