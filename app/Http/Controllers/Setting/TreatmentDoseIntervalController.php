<?php

namespace App\Http\Controllers\Setting;

use App\Models\TreatmentDoseInterval;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class TreatmentDoseIntervalController extends Controller
{
    public function create(Request $request)
    {
         if(!checkPersonPermission('create_medication_dose_interval_16')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.treatment_dose_interval.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new TreatmentDoseInterval();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {
        $obj = TreatmentDoseInterval::find($request->id);
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_medication_dose_interval_16')) {
               return ErrorMessage(403);
        }
        
        $preferences = UserPreferences::getPreferences();

        return view('modules.treatment_dose_interval.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_medication_dose_interval_16')) {
               return ErrorMessage(403);
        }
        $obj = TreatmentDoseInterval::find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.treatment_dose_interval.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_medication_dose_interval_16')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = TreatmentDoseInterval::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid ID provided.',
        ]);
    }
}
