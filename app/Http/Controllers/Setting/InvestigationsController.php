<?php

namespace App\Http\Controllers\Setting;

use App\Exports\DataExport;
use App\Imports\DataImport;
use App\Models\CdInvestigations;
use Illuminate\Http\Request;
use App\Models\Investigations;
use App\Models\UserPreferences;
use App\Models\InvestigationType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use App\Models\InvestigationAttachedField;

class InvestigationsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_investigations_26')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $types = InvestigationType::getActiveInvestigationTypes();

        $ips = 'Investigations';
        return view('modules.investigations.create', compact('preferences', 'ips', 'types'));
    }

    public static function details ($id) {

        $preferences = UserPreferences::getPreferences();
        $ips = 'Investigations Detail';
        $types = InvestigationType::getActiveInvestigationTypes();
        $investigation = Investigations::findOrFail($id);
        $page = 'investigations';
        $tab = 'prices';

        return view('modules.investigations.investigation_details', compact('preferences', 'ips', 'types', 'investigation','page','tab'));
    }

    public function store(Request $request)
    {
        $obj = new Investigations();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {
        $obj = Investigations::find($request->id);
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_investigations_26')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();

        return view('modules.investigations.index', compact('preferences'));
    }

    public function show($id)
    {
        $investigation = Investigations::findOrFail($id);
        $preferences = UserPreferences::getPreferences();
        $page = 'investigations';
        $investigation_id = $id;

        $attachedFields = $investigation->getAttachedFields();
        $customFields = $investigation->getAvailableCustomFields();

        return view('modules.investigations.detail', compact(
            'preferences',
            'investigation',
            'page',
            'investigation_id',
            'attachedFields',
            'customFields'
        ));
    }

    public function detachAttachedField(Request $request)
    {
        $attachedId = $request->input('attached_id');

        InvestigationAttachedField::softDeleteById($attachedId);

        return response()->json(['message' => 'Detached and added to custom fields']);
    }

    public function attachField(Request $request)
    {
        $request->validate([
            'field_id' => 'required|integer',
            'investigation_id' => 'required|integer',
        ]);

        $userId = auth()->user()->id;

        $result = InvestigationAttachedField::attachOrRestoreField(
            $request->investigation_id,
            $request->field_id,
            $userId
        );

        return response()->json($result);
    }


    public function edit($id)
    {
        if(!checkPersonPermission('update_investigations_26')) {
               return ErrorMessage(403);
        }
        $obj = Investigations::find($id);
        $preferences = UserPreferences::getPreferences();
        $types = InvestigationType::getActiveInvestigationTypes();

        $ips = 'Investigations';
        return view('modules.investigations.update', compact('preferences', 'obj', 'ips', 'types'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_investigations_26')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Investigations::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid ID provided.',
        ]);
    }

    public function export()
    {
        try {

            $modelName = 'Investigations';
            $schema = 'investigations';
            return Excel::download(new DataExport($modelName), $schema . '.xlsx');

        } catch (Exception $e) {
            $response = $e->getMessage();
            session()->flash('error', $response);
            return Redirect::route($schema . '.index');
        }
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:investigations,id',
            'verification_status' => 'required|in:approved,pending,rejected',
        ]);

        $investigation = Investigations::findOrFail($request->id);
        $investigation->verification_status = $request->verification_status;

        if ($investigation->verification_status === 'rejected') {
            $investigation->rejected_by = auth()->id();
            $investigation->approved_by = null;

            CdInvestigations::where('investigation_id', $investigation->id)->delete();
        } elseif ($investigation->verification_status === 'approved') {
            $investigation->approved_by = auth()->id();
            $investigation->rejected_by = null;

            CdInvestigations::withTrashed()
                ->where('investigation_id', $investigation->id)
                ->whereNotNull('deleted_at')
                ->restore();
        } else {
            $investigation->approved_by = null;
            $investigation->rejected_by = null;
            $investigation->updated_by = auth()->id();

            CdInvestigations::withTrashed()
                ->where('investigation_id', $investigation->id)
                ->whereNotNull('deleted_at')
                ->restore();
        }

        $investigation->save();

        return response()->json(['success' => true]);
    }


}
