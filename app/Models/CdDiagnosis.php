<?php

namespace App\Models;

use App\Models\Diagnosis;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\CdDiagnosisDetail;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdDiagnosis extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cd_id',
        'diagnosis_id',
        'remarks',
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
        return $this->belongsTo(Diagnosis::class);
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
        $tabName = 'diagnosis';
        $cd_id = request('cd_id');

        $validator = Validator::make(request()->all(), [
            'kt_docs_repeater_advanced_diagnosis.*.selectDiagnosis' => 'required',
            'kt_docs_repeater_advanced_diagnosis.*.remarks' => 'nullable',
            'kt_docs_repeater_advanced_diagnosis.*.selectDiagnosisCategory' => 'required',
        ], [
            'kt_docs_repeater_advanced_diagnosis.*.selectDiagnosis.required' => 'A diagnosis must be selected',
            'kt_docs_repeater_advanced_diagnosis.*.selectDiagnosisCategory.required' => 'At least one diagnosis category must be selected',
        ]);

        if ($validator->fails()) {
            return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                ->withErrors($validator)
                ->withInput();
        }

        $repeater_data = request('kt_docs_repeater_advanced_diagnosis');

        if (is_null($repeater_data)) {
            session()->flash('error', 'No diagnosis data provided');
            return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => 'procedure'])
                ->withInput();
        }

        try {
            foreach ($repeater_data as $value) {
                // Check if required fields exist in the repeater data
                if (!array_key_exists('selectDiagnosis', $value)) {
                    continue; // Skip this iteration if required fields are missing
                }

                $diagnosisId = $value['selectDiagnosis'];

                if (!is_numeric($diagnosisId)) {
                    $newDiagnosis = Diagnosis::create([
                        'name' => $diagnosisId,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);

                    $diagnosisId = $newDiagnosis->id;
                }

                $matchThese = [
                    'diagnosis_id' => $diagnosisId,
                    'cd_id' => $cd_id
                ];

                $obj = CdDiagnosis::updateOrCreate($matchThese, [
                    'created_by' => auth()->user()->id,
                    'remarks' => $value['remarks'] ?? null,
                    'diagnosis_category_id' => $value['selectDiagnosisCategory'] ?? null,
                ]);

                $cd_diagnosis_id = $obj->id;

                // Ensure selectSubDiagnosis is an array before processing
                // if (is_array($value['selectSubDiagnosis'])) {
                //     foreach ($value['selectSubDiagnosis'] as $selectSubGPEKey => $selectSubGPEVal) {
                //         if (null === $selectSubGPEVal) {
                //             continue; // Skip if sub-diagnosis value is not set
                //         }

                //         $matchThese = [
                //             'cd_diagnosis_id' => intVal($cd_diagnosis_id),
                //             'diagnosis_id' => intVal($selectSubGPEVal)
                //         ];

                //         $CdDiagnosisDetail = CdDiagnosisDetail::updateOrCreate($matchThese, [
                //             'created_by' => auth()->user()->id
                //         ]);
                //     }
                // }
            }

            session()->flash('success', 'Diagnosis added successfully');
            $tabName = 'procedure';
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");

        } catch (\Exception $e) {
            session()->flash('error', 'Error processing diagnosis data: ' . $e->getMessage());
            return back();
        }
    }

    public function updateForm($request = false)
    {
        $cd_id = request('cd_id');

        if ($cd_id) {
            // If diagnosis data is empty (all entries removed), soft delete existing data
            if (!request()->has('kt_docs_repeater_advanced_diagnosis')) {
                CdDiagnosis::where('cd_id', $cd_id)->delete();
                session()->flash('success', 'Diagnosis data removed successfully');
                $tabName = 'procedure';
                return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
            }

            request()->validate([
                'kt_docs_repeater_advanced_diagnosis.*.selectDiagnosis' => 'required',
                // 'kt_docs_repeater_advanced_diagnosis.*.selectSubDiagnosis' => 'required',
            ], [
                'kt_docs_repeater_advanced_diagnosis.*.selectDiagnosis.required' => 'A diagnosis must be selected',
                // 'kt_docs_repeater_advanced_diagnosis.*.selectSubDiagnosis.required' => 'At least one sub-diagnosis must be selected',
            ]);

            try {

                // First, soft delete all existing records
                CdDiagnosis::where('cd_id', $cd_id)->delete();
                $repeater_data = request('kt_docs_repeater_advanced_diagnosis');
                $submitted_diagnosis_ids = collect($repeater_data)->pluck('selectDiagnosis')->toArray();

                foreach ($repeater_data as $value) {
                    $diagnosisId = $value['selectDiagnosis'];

    // Handle tags (non-numeric means it's a new tag)
    if (!is_numeric($diagnosisId)) {
        // Check if it already exists (case-insensitive)
        $existingDiagnosis = Diagnosis::whereRaw('LOWER(name) = ?', [strtolower($diagnosisId)])->first();

        if ($existingDiagnosis) {
            $diagnosisId = $existingDiagnosis->id;
        } else {
            // Create new diagnosis as tag
            $newDiagnosis = Diagnosis::create([
                'name' => $diagnosisId,
                'status' => 1,
                'verification_status' => 'pending',
                'is_manual' => 1,
                'created_by' => auth()->user()->id,
            ]);
            $diagnosisId = $newDiagnosis->id;
        }
    }

    // Check if record exists (including soft deleted)
    $existing_diagnosis = CdDiagnosis::where('diagnosis_id', $diagnosisId)
        ->where('cd_id', $cd_id)
        ->withTrashed()
        ->first();

    if ($existing_diagnosis) {
        // Restore and update existing record
        $existing_diagnosis->restore();
        $existing_diagnosis->remarks = $value['remarks'] ?? null;
        $existing_diagnosis->diagnosis_category_id = $value['selectDiagnosisCategory'] ?? null;
        $existing_diagnosis->save();
        $cd_diagnosis_id = $existing_diagnosis->id;

    } else {
        // Create new record
        $new_diagnosis = CdDiagnosis::create([
            'diagnosis_id' => $diagnosisId,
            'cd_id' => $cd_id,
            'created_by' => auth()->user()->id,
            'remarks' => $value['remarks'] ?? null,
            'diagnosis_category_id' => $value['selectDiagnosisCategory'] ?? null,
        ]);
        $cd_diagnosis_id = $new_diagnosis->id;
    }

                    // Handle sub-diagnoses
                    // if (isset($value['selectSubDiagnosis']) && is_array($value['selectSubDiagnosis'])) {
                    //     // Soft delete existing sub-diagnoses
                    //     CdDiagnosisDetail::where('cd_diagnosis_id', $cd_diagnosis_id)->delete();

                    //     foreach ($value['selectSubDiagnosis'] as $selectSubDiagnosisVal) {
                    //         // Check if sub-diagnosis exists
                    //         $existing_sub = CdDiagnosisDetail::where('cd_diagnosis_id', $cd_diagnosis_id)
                    //             ->where('diagnosis_id', $selectSubDiagnosisVal)
                    //             ->withTrashed()
                    //             ->first();

                    //         if ($existing_sub) {
                    //             // Restore and update existing sub-diagnosis
                    //             $existing_sub->restore();
                    //             $existing_sub->updated_by = auth()->user()->id;
                    //             $existing_sub->save();
                    //         } else {
                    //             // Create new sub-diagnosis
                    //             CdDiagnosisDetail::create([
                    //                 'cd_diagnosis_id' => $cd_diagnosis_id,
                    //                 'diagnosis_id' => $selectSubDiagnosisVal,
                    //                 'created_by' => auth()->user()->id
                    //             ]);
                    //         }
                    //     }
                    // }
                }

                session()->flash('success', 'Diagnosis updated successfully');
                $tabName = 'procedure';
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
            'message' => 'Cd Diagnosis has been deleted successfully',
        ]);
    }

    public static function getDiagnosisData ($cd_id) {
        $diagnosisData = \App\Models\CdDiagnosis::join('diagnosis as diagnosis','diagnosis.id','cd_diagnoses.diagnosis_id')
        ->leftjoin('diagnosis_categories as diagnosis_categories','diagnosis_categories.id','cd_diagnoses.diagnosis_category_id')
        ->select([
            'cd_diagnoses.id as cd_diagnosis_id',
            'diagnosis.name as diagnosis_name',
            'diagnosis_categories.name as diagnosis_category_name',
            'cd_diagnoses.remarks',
            'cd_diagnoses.created_at'
        ])
        ->where('cd_diagnoses.cd_id',$cd_id)
        ->get();

        foreach ($diagnosisData as $d) {
        $child_data = \App\Models\CdDiagnosisDetail::join('diagnosis as diagnosis','diagnosis.id','cd_diagnosis_details.diagnosis_id')
        ->select([
            'diagnosis.name as diagnosis_name',
        ])
        ->where('cd_diagnosis_details.cd_diagnosis_id',$d->cd_diagnosis_id)
        ->get();

          $d->child_data = $child_data;
        }

        return $diagnosisData;
    }
}
