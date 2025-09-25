<?php

namespace App\Http\Controllers\Setting;

use App\Models\CdSystematicPhysicalExamination;
use App\Models\SystematicPhysicalExamination;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class SystematicPhysicalExaminationsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_systematic_physical_examination_22')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $spe = SystematicPhysicalExamination::getParentSPEs();

        return view('modules.systematic_physical_examinations.create', compact('preferences', 'spe'));
    }

    public function store()
    {
        $obj = new SystematicPhysicalExamination();
        return $obj->addForm();
    }

    public function update($id)
    {
        $obj = SystematicPhysicalExamination::find($id);
        return $obj->updateForm($id);
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_systematic_physical_examination_22')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.systematic_physical_examinations.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_systematic_physical_examination_22')) {
               return ErrorMessage(403);
        }
        $obj = SystematicPhysicalExamination::find($id);
        $preferences = UserPreferences::getPreferences();
        $spe = SystematicPhysicalExamination::getParentSPEs();

        return view('modules.systematic_physical_examinations.update', compact('preferences', 'obj', 'spe'));
    }

    public function delete($id)
    {
         if(!checkPersonPermission('delete_systematic_physical_examination_22')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = SystematicPhysicalExamination::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Systematic physical examination not found',
        ]);
    }

    public function fetchSPEs(Request $request)
    {
        if ($request->spe_id) {
          $spe_id = $request->spe_id;
          $data = SystematicPhysicalExamination::where("parent_id", $spe_id)->where('verification_status', '!=', 'rejected')->get(["name", "id"]);
          return response()->json($data);
        }
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:systematic_physical_examinations,id',
            'verification_status' => 'required|in:approved,pending,rejected',
        ]);

        $spe = SystematicPhysicalExamination::findOrFail($request->id);
        $spe->verification_status = $request->verification_status;

        if ($spe->verification_status === 'rejected') {
            $spe->rejected_by = auth()->id();
            $spe->approved_by = null;

            CdSystematicPhysicalExamination::where('spe_id', $spe->id)->delete();
        } elseif ($spe->verification_status === 'approved') {
            $spe->approved_by = auth()->id();
            $spe->rejected_by = null;

            CdSystematicPhysicalExamination::withTrashed()
                ->where('spe_id', $spe->id)
                ->whereNotNull('deleted_at')
                ->restore();
        } else {
            $spe->approved_by = null;
            $spe->rejected_by = null;
            $spe->updated_by = auth()->id();

            CdSystematicPhysicalExamination::withTrashed()
                ->where('spe_id', $spe->id)
                ->whereNotNull('deleted_at')
                ->restore();
        }

        $spe->save();

        return response()->json(['success' => true]);
    }

}
