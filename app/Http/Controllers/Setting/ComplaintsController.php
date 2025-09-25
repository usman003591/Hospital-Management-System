<?php

namespace App\Http\Controllers\Setting;

use App\Models\CdComplaint;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class ComplaintsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_complaints_20')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $complaints = Complaint::getParentComplaints();

        return view('modules.complaints.create', compact('preferences', 'complaints'));
    }

    public function store()
    {
        $obj = new Complaint();
        return $obj->addForm();
    }

    public function update($id)
    {
        $obj = Complaint::find($id);
        return $obj->updateForm($id);
    }

    public function index(Request $request)
    {
          if(!checkPersonPermission('list_complaints_20')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.complaints.index', compact('preferences'));
    }

    public function edit($id)
    {
          if(!checkPersonPermission('update_complaints_20')) {
               return ErrorMessage(403);
        }
        $obj = Complaint::find($id);
        $preferences = UserPreferences::getPreferences();
        $complaints = Complaint::getParentComplaints();

        return view('modules.complaints.update', compact('preferences', 'obj', 'complaints'));
    }

    public function delete($id)
    {
  if(!checkPersonPermission('delete_complaints_20')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Complaint::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Complaint not found',
        ]);
    }

    public function fetchComplaints(Request $request)
    {
        if ($request->complaint_id) {
            $complaint_id = $request->complaint_id;
            $data = Complaint::where("parent_id", $complaint_id)->where('verification_status', '!=', 'rejected')->get(["name", "id"]);
            return response()->json($data);
        }
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:complaints,id',
            'verification_status' => 'required|in:approved,pending,rejected',
        ]);

        $complaint = Complaint::findOrFail($request->id);
        $complaint->verification_status = $request->verification_status;

        if ($complaint->verification_status === 'rejected') {
            $complaint->rejected_by = auth()->id();
            $complaint->approved_by = null;

            CdComplaint::where('complaint_id', $complaint->id)->delete();
        } elseif ($complaint->verification_status === 'approved') {
            $complaint->approved_by = auth()->id();
            $complaint->rejected_by = null;

            CdComplaint::withTrashed()
                ->where('complaint_id', $complaint->id)
                ->whereNotNull('deleted_at')
                ->restore();
        } else {
            $complaint->approved_by = null;
            $complaint->rejected_by = null;
            $complaint->updated_by = auth()->id();

            CdComplaint::withTrashed()
                ->where('complaint_id', $complaint->id)
                ->whereNotNull('deleted_at')
                ->restore();
        }

        $complaint->save();

        return response()->json(['success' => true]);
    }

}
