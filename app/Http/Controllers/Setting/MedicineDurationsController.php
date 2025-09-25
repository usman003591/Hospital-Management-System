<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\MedicineDuration;
use App\Http\Controllers\Controller;

class MedicineDurationsController extends Controller
{
    public function create()
    {
        if(!checkPersonPermission('create_medicine_durations_58')) {
               return ErrorMessage(403);
        }
        $page = 'medicine_durations';
        $module = 'Medicine Duration';
        $preferences = UserPreferences::getPreferences();
        return view('modules.medicine_durations.create', compact('preferences', 'module', 'page'));
    }
    public function store(Request $request)
    {
        $obj = new MedicineDuration();
        return $obj->addForm($request);
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_medicine_durations_58')) {
               return ErrorMessage(403);
        }
        $page = 'medicine_durations';
        $module = 'Medicine Duration';
        $obj = MedicineDuration::find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.medicine_durations.update', compact('preferences', 'obj', 'page', 'module'));
    }

    public function update($id)
    {
        $obj = new MedicineDuration();
        return $obj->updateForm($id);
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_medicine_durations_58')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.medicine_durations.index', compact('preferences'));
    }

    public function delete(string $id)
    {
        if(!checkPersonPermission('delete_medicine_durations_58')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = MedicineDuration::find($id);
            return $obj->deleteObj();
        }

    }
}
