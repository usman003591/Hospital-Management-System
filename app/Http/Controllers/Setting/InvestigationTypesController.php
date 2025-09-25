<?php

namespace App\Http\Controllers\Setting;

use App\Models\InvestigationType;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class InvestigationTypesController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_investigation_types_27')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.investigation_types.create', compact('preferences'));
    }

    public function store()
    {
        $obj = new InvestigationType();
        return $obj->addForm();
    }

    public function update($id)
    {
        $obj = InvestigationType::find($id);
        return $obj->updateForm($id);
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_investigation_types_27')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.investigation_types.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_investigation_types_27')) {
               return ErrorMessage(403);
        }
        $obj = InvestigationType::find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.investigation_types.update', compact('preferences', 'obj'));
    }

    public function delete($id)
    {
        if(!checkPersonPermission('delete_investigation_types_27')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = InvestigationType::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Investigation Type not found',
        ]);
    }
}
