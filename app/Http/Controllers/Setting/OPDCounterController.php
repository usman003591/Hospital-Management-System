<?php

namespace App\Http\Controllers\Setting;

use App\Models\OPDCounter;
use App\Models\UserPreferences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OPDCounterController extends Controller
{
    public function index(Request $request)
    {
        
        if(!checkPersonPermission('list_opd_counter_57')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.opd_counter.index', compact('preferences'));
    }

    public function create(Request $request)
    {
         if(!checkPersonPermission('create_opd_counter_57')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.opd_counter.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new OPDCounter();
        return $obj->addForm($request);
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_opd_counter_57')) {
               return ErrorMessage(403);
        }
        $obj = OPDCounter::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.opd_counter.update', compact('preferences', 'obj'));
    }

    public function update(Request $request)
    {
        $obj = new OPDCounter();
        return $obj->updateForm($request);
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_opd_counter_57')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = OPDCounter::find($id);
            return $obj->deleteObj();
        }
    }
}
