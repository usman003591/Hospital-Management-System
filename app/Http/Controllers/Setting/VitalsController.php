<?php

namespace App\Http\Controllers\Setting;

use App\Models\Vital;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class VitalsController extends Controller
{
    public function create()
    {
        if(!checkPersonPermission('create_vitals_23')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $obj = new Vital();
        return view('modules.vitals.create', compact('preferences', 'obj'));
    }

    public function store()
    {
        $obj = new Vital();
        return $obj->addForm();
    }

    public function update($id)
    {
        $obj = new Vital();
        return $obj->updateForm($id);
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_vitals_23')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.vitals.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_vitals_23')) {
               return ErrorMessage(403);
        }
        $obj = Vital::find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.vitals.update', compact('preferences', 'obj'));
    }

    public function delete($id)
    {
        if(!checkPersonPermission('delete_vitals_23')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Vital::find($id);
            return $obj->deleteObj();
        }
    }
}
