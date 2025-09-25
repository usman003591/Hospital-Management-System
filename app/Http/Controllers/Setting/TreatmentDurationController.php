<?php

namespace App\Http\Controllers\Setting;

use App\Models\TreatmentDuration;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class TreatmentDurationController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_medication_frequency_15')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.treatment_duration.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new TreatmentDuration();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {
        $obj = TreatmentDuration::find($request->id);
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_medication_frequency_15')) {
               return ErrorMessage(403);
        }
        $d = TreatmentDuration::getAll();

        $page = 'treatment_duration';
        $data = $d['data'];
        $search = $d['search'];

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.treatment_duration.include.list_partial', compact('data', 'page', 'search'))->render(),
            ]);
        }

        $preferences = UserPreferences::getPreferences();

        return view('modules.treatment_duration.index', compact('preferences', 'page', 'search', 'data'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_medication_frequency_15')) {
               return ErrorMessage(403);
        }
        $obj = TreatmentDuration::find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.treatment_duration.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_medication_frequency_15')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = TreatmentDuration::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid ID provided.',
        ]);
    }
}
