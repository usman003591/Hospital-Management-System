<?php

namespace App\Models;

use App\Models\Procedure;
use App\Models\CdDiagnosis;
use App\Models\CdDiagnosisDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdProcedure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cd_id',
        'procedure_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function cd()
    {
        return $this->belongsTo(ClinicalDiagnosis::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Procedure::class);
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('cd_id', $search['q']);
        }


        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        $cd_id = request('cd_id');
        $tabName = 'procedure';

        $validator = Validator::make(request()->all(), [
            'kt_docs_repeater_advanced_procedure.*.selectProcedure' => 'required',
        ], [
            'kt_docs_repeater_advanced_procedure.*.selectProcedure.required' => 'A Procedure must be selected',
        ]);

        if ($validator->fails()) {
            return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                ->withErrors($validator)
                ->withInput();
        }

        $repeater_data = request('kt_docs_repeater_advanced_procedure');

        try {
            foreach ($repeater_data as $value) {
                if (!array_key_exists('selectProcedure', $value)) {
                    continue;
                }

                $procedureId = $value['selectProcedure'];

                // If the value is not numeric, treat it as a new custom tag
                if (!is_numeric($procedureId)) {
                    $newProcedure = Procedure::create([
                        'name' => $procedureId,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);

                    $procedureId = $newProcedure->id;
                }

                $matchThese = [
                    'procedure_id' => $procedureId,
                    'cd_id' => $cd_id
                ];

                CdProcedure::updateOrCreate($matchThese, [
                    'created_by' => auth()->user()->id
                ]);
            }

            session()->flash('success', 'Patient Procedure added successfully');
            $tabName = 'treatment';
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");

        } catch (\Exception $e) {
            session()->flash('error', 'Error processing procedure data: ' . $e->getMessage());
            return back();
        }
    }

    public function updateForm($request = false)
    {
        $cd_id = request('cd_id');
        $tabName = 'treatment';

        if ($cd_id) {
            // If diagnosis data is empty (all entries removed), soft delete existing data
            if (!request()->has('kt_docs_repeater_advanced_procedure')) {
                CdProcedure::where('cd_id', $cd_id)->delete();
                session()->flash('success', 'Patient procedure data removed successfully');
                return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
            }

            $validator = Validator::make(request()->all(), [
                'kt_docs_repeater_advanced_procedure.*.selectProcedure' => 'required',
            ], [
                'kt_docs_repeater_advanced_procedure.*.selectProcedure.required' => 'A procedure must be selected',
            ]);

            if ($validator->fails()) {
                return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                    ->withErrors($validator)
                    ->withInput();
            }

            try {

                CdProcedure::where('cd_id', $cd_id)->delete();
                $repeater_data = request('kt_docs_repeater_advanced_procedure');

                foreach ($repeater_data as $value) {
                    if (!array_key_exists('selectProcedure', $value)) {
                        continue;
                    }

                    $procedureId = $value['selectProcedure'];

                    // If it's a new custom tag (not numeric), create it
                    if (!is_numeric($procedureId)) {
                        $newProcedure = Procedure::create([
                            'name' => $procedureId,
                            'status' => 1,
                            'verification_status' => 'pending',
                            'is_manual' => 1,
                            'created_by' => auth()->user()->id,
                        ]);

                        $procedureId = $newProcedure->id;
                    }


                    // Restore if soft-deleted, or create new
                    $existing = CdProcedure::withTrashed()
                        ->where('procedure_id', $procedureId)
                        ->where('cd_id', $cd_id)
                        ->first();

                    if ($existing) {
                        $existing->restore();
                        $existing->updated_by = auth()->user()->id;
                        $existing->save();
                    } else {
                        CdProcedure::create([
                            'procedure_id' => $procedureId,
                            'cd_id' => $cd_id,
                            'created_by' => auth()->user()->id
                        ]);
                    }
                }
                session()->flash('success', 'Patient procedure updated successfully');
                $tabName = 'treatment';
                return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");

            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
                return back();
            }
        } else {
            session()->flash('error', 'Invalid request: Missing cd_id');
            return back();
        }
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Cd Procedure has been deleted successfully',
        ]);
    }

    public static function getProcedureData($cd_id)
    {
        $procedureData = CdProcedure::join('procedures as procedure', 'procedure.id', 'cd_procedures.procedure_id')
            ->select([
                'cd_procedures.id as cd_procedure_id',
                'procedure.name as procedure_name',
            ])
            ->where('cd_procedures.cd_id', $cd_id)
            ->get();

        return $procedureData;
    }
}

