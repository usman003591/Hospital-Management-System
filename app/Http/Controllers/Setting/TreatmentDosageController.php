<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\TreatmentDosage;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class TreatmentDosageController extends Controller
{
    
    public function create(Request $request)
    {
         if(!checkPersonPermission('create_medication_quantity_14')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.treatment_dosage.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new TreatmentDosage();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {
        $obj = TreatmentDosage::find($request->id);
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_medication_quantity_14')) {
               return ErrorMessage(403);
        }
      
        $preferences = UserPreferences::getPreferences();

        return view('modules.treatment_dosage.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_medication_quantity_14')) {
               return ErrorMessage(403);
        }
        $obj = TreatmentDosage::find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.treatment_dosage.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_medication_quantity_14')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = TreatmentDosage::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid ID provided.',
        ]);
    }
}
