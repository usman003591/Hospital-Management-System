<?php

namespace App\Http\Controllers\Setting;

use App\Models\CdDiagnosis;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use DB;

class DiagnosisController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_diagnosis_25')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        // $diagnosis = Diagnosis::getParentDiagnosis();

        $ips = 'Diagnosis';
        return view('modules.diagnosis.create', compact('preferences', 'ips'));
    }

    public function store()
    {
        $obj = new Diagnosis();
        return $obj->addForm();
    }

    public function update($id)
    {
        $obj = Diagnosis::find($id);
        return $obj->updateForm($id);
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_diagnosis_25')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.diagnosis.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_diagnosis_25')) {
               return ErrorMessage(403);
        }
        $obj = Diagnosis::find($id);
        $preferences = UserPreferences::getPreferences();
        // $diagnosis = Diagnosis::getParentDiagnosis();
        $ips = 'Diagnosis';

        return view('modules.diagnosis.update', compact('preferences', 'obj', 'ips'));
    }

    public function delete($id)
    {
        if(!checkPersonPermission('delete_diagnosis_25')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Diagnosis::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Diagnosis not found',
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->q;
        $query = strtolower($query);

        $data = Diagnosis::where(function ($q) use ($query) {
            $q->where('name', 'ILIKE', "%{$query}%")
                ->orWhere('code', 'ILIKE', "%{$query}%");
        })
            ->where('verification_status', '!=', 'rejected') // Exclude rejected diagnoses
            ->select('id', DB::raw("CONCAT(code, ' ', name) AS display_name"))
            ->limit(10)
            ->get();

        return response()->json($data);

        // ->get(['id', 'name']);
        //whereRaw('LOWER(name)','like',"%{$query}%")
        // return response()->json(['results' => $data]);

    }


    public function fetchDiagnosis(Request $request)
    {
        if ($request->diagnosis_id) {
            $diagnosis_id = $request->diagnosis_id;
            $data = Diagnosis::where("parent_id", $diagnosis_id)->get(["name", "id"]);
            return response()->json($data);
        }
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:diagnosis,id',
            'verification_status' => 'required|in:approved,pending,rejected',
        ]);

        $diagnosis = Diagnosis::findOrFail($request->id);
        $diagnosis->verification_status = $request->verification_status;

        if ($diagnosis->verification_status === 'rejected') {
            $diagnosis->rejected_by = auth()->id();
            $diagnosis->approved_by = null;

            CdDiagnosis::where('diagnosis_id', $diagnosis->id)->delete();
        } elseif ($diagnosis->verification_status === 'approved') {
            $diagnosis->approved_by = auth()->id();
            $diagnosis->rejected_by = null;

            CdDiagnosis::withTrashed()
                ->where('diagnosis_id', $diagnosis->id)
                ->whereNotNull('deleted_at')
                ->restore();
        } else {
            $diagnosis->approved_by = null;
            $diagnosis->rejected_by = null;
            $diagnosis->updated_by = auth()->id();

            CdDiagnosis::withTrashed()
                ->where('diagnosis_id', $diagnosis->id)
                ->whereNotNull('deleted_at')
                ->restore();
        }

        $diagnosis->save();

        return response()->json(['success' => true]);
    }



}
