<?php

namespace App\Http\Controllers\Setting;

use App\Models\Procedure;
use App\Models\CdProcedure;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class ProcedureController extends Controller
{
    public function index(Request $request)
    {
         if(!checkPersonPermission('list_procedures_31')) {
               return ErrorMessage(403);
        }
       
        $preferences = UserPreferences::getPreferences();

        return view('modules.procedures.index', compact('preferences'));
    }

    public function create()
    {
         if(!checkPersonPermission('create_procedures_31')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.procedures.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        $procedure = new Procedure();
        $result = $procedure->addForm($request);

        if ($result) {
            return redirect()->route('procedures.index')->with('success', 'Procedure created successfully.');
        }

        return redirect()->back()->with('error', 'Failed to create procedure.');
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_procedures_31')) {
               return ErrorMessage(403);
        }
        $status = Procedure::findOrFail($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.procedures.update', compact('preferences', 'status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        $status = Procedure::findOrFail($id);
        $result = $status->updateForm($request);

        if ($result) {
            return redirect()->route('procedures.index')->with('success', 'Procedure updated successfully.');
        }

        return redirect()->back()->with('error', 'Failed to update procedure.');
    }


    public function delete($id)
    {

       if(!checkPersonPermission('delete_procedures_31')) {
               return ErrorMessage(403);
        }

        $status = Procedure::find($id);

        if ($status) {
            $status->update(['deleted_by' => auth()->id()]);
            $status->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Procedure deleted successfully.',
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Failed to delete procedure.',
        ]);
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:procedures,id',
            'verification_status' => 'required|in:approved,pending,rejected',
        ]);

        $procedure = Procedure::findOrFail($request->id);
        $procedure->verification_status = $request->verification_status;

        if ($procedure->verification_status === 'rejected') {
            $procedure->rejected_by = auth()->id();
            $procedure->approved_by = null;

            CdProcedure::where('procedure_id', $procedure->id)->delete();
        } elseif ($procedure->verification_status === 'approved') {
            $procedure->approved_by = auth()->id();
            $procedure->rejected_by = null;

            CdProcedure::withTrashed()
                ->where('procedure_id', $procedure->id)
                ->whereNotNull('deleted_at')
                ->restore();
        } else {
            $procedure->approved_by = null;
            $procedure->rejected_by = null;
            $procedure->updated_by = auth()->id();

            CdProcedure::withTrashed()
                ->where('procedure_id', $procedure->id)
                ->whereNotNull('deleted_at')
                ->restore();
        }

        $procedure->save();

        return response()->json(['success' => true]);
    }

}
