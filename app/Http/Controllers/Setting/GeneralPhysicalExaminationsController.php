<?php

namespace App\Http\Controllers\Setting;

use App\Models\CdGeneralPhysicalExamination;
use App\Models\GeneralPhysicalExamination;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class GeneralPhysicalExaminationsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_general_physical_examination_21')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $gpe = GeneralPhysicalExamination::getParentGPEs();
        return view('modules.general_physical_examinations.create', compact('preferences', 'gpe'));
    }

    public function store()
    {
        $obj = new GeneralPhysicalExamination();
        return $obj->addForm();
    }

    public function update($id)
    {
        $obj = GeneralPhysicalExamination::find($id);
        return $obj->updateForm($id);
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_general_physical_examination_21')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();

        return view('modules.general_physical_examinations.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_general_physical_examination_21')) {
               return ErrorMessage(403);
        }
        $obj = GeneralPhysicalExamination::find($id);
        $preferences = UserPreferences::getPreferences();
        $gpe = GeneralPhysicalExamination::getParentGPEs();

        return view('modules.general_physical_examinations.update', compact('preferences', 'obj', 'gpe'));
    }

    public function delete($id)
    {
         if(!checkPersonPermission('delete_general_physical_examination_21')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = GeneralPhysicalExamination::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'General physical examination not found',
        ]);
    }

    public function fetchGPEs(Request $request)
    {
        if ($request->gpe_id) {
          $gpe_id = $request->gpe_id;
          $data = GeneralPhysicalExamination::where("parent_id", $gpe_id)->where('verification_status', '!=', 'rejected')->get(["name", "id"]);
          return response()->json($data);
        }
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:general_physical_examinations,id',
            'verification_status' => 'required|in:approved,pending,rejected',
        ]);

        $gpe = GeneralPhysicalExamination::findOrFail($request->id);
        $gpe->verification_status = $request->verification_status;

        if ($gpe->verification_status === 'rejected') {
            $gpe->rejected_by = auth()->id();
            $gpe->approved_by = null;

            CdGeneralPhysicalExamination::where('gpe_id', $gpe->id)->delete();
        } elseif ($gpe->verification_status === 'approved') {
            $gpe->approved_by = auth()->id();
            $gpe->rejected_by = null;

            CdGeneralPhysicalExamination::withTrashed()
                ->where('gpe_id', $gpe->id)
                ->whereNotNull('deleted_at')
                ->restore();
        } else {
            $gpe->approved_by = null;
            $gpe->rejected_by = null;
            $gpe->updated_by = auth()->id();

            CdGeneralPhysicalExamination::withTrashed()
                ->where('gpe_id', $gpe->id)
                ->whereNotNull('deleted_at')
                ->restore();
        }

        $gpe->save();

        return response()->json(['success' => true]);
    }


}
