<?php

namespace App\Http\Controllers\Setting;

use App\Models\CdTreatment;
use App\Models\Medicines;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\MedicineCategory;
use App\Http\Controllers\Controller;

class MedicinesController extends Controller
{
    public function create(Request $request)
    {
         if(!checkPersonPermission('create_medicines_24')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $medicine_categories = MedicineCategory::getActiveCategories();

        $ips = 'Medicines';
        return view('modules.medicines.create', compact('preferences', 'ips','medicine_categories'));
    }

    public function store(Request $request)
    {
        $obj = new Medicines();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {
        $obj = Medicines::find($request->id);
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_medicines_24')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.medicines.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_medicines_24')) {
               return ErrorMessage(403);
        }
        $obj = Medicines::find($id);
        $preferences = UserPreferences::getPreferences();
        $medicine_categories = MedicineCategory::getActiveCategories();

        $ips = 'Medicines';
        return view('modules.medicines.update', compact('preferences', 'obj', 'ips','medicine_categories'));
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_medicines_24')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Medicines::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid ID provided.',
        ]);

    }

    public function search(Request $request)
    {
            $query = strtolower($request->q);
            $data = Medicines::where(function ($q) use ($query) {
                $q->where('name', 'ILIKE', "%{$query}%");
            })
            ->where('verification_status', '!=', 'rejected') // Exclude rejected diagnoses
            ->select([
                'id',
                'name as display_name'
            ])
            ->get();

        return response()->json($data);

    }

    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:procedures,id',
            'verification_status' => 'required|in:approved,pending,rejected',
        ]);

        $medicine = Medicines::findOrFail($request->id);
        $medicine->verification_status = $request->verification_status;

        if ($medicine->verification_status === 'rejected') {
            $medicine->rejected_by = auth()->id();
            $medicine->approved_by = null;

            CdTreatment::where('medicine_id', $medicine->id)->delete();
        } elseif ($medicine->verification_status === 'approved') {
            $medicine->approved_by = auth()->id();
            $medicine->rejected_by = null;

            CdTreatment::withTrashed()
                ->where('medicine_id', $medicine->id)
                ->whereNotNull('deleted_at')
                ->restore();
        } else {
            $medicine->approved_by = null;
            $medicine->rejected_by = null;
            $medicine->updated_by = auth()->id();

            CdTreatment::withTrashed()
                ->where('medicine_id', $medicine->id)
                ->whereNotNull('deleted_at')
                ->restore();
        }

        $medicine->save();

        return response()->json(['success' => true]);
    }

}
