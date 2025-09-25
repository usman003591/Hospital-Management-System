<?php

namespace App\Models;

use DB;
use App\Models\ClinicalDiagnosis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\SystematicPhysicalExamination;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;
use App\Models\CdSystematicPhysicalExaminationDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdSystematicPhysicalExamination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['spe_id', 'cd_id', 'remarks', 'created_by', 'updated_by', 'deleted_by'];

    // Relationships
    public function systematicPhysicalExamination()
    {
        return $this->belongsTo(SystematicPhysicalExamination::class, 'spe_id');
    }

    public function clinicalDiagnosis()
    {
        return $this->belongsTo(ClinicalDiagnosis::class, 'cd_id');
    }

    public function cdSystematicPhysicalExaminationDetails()
    {
        return $this->hasMany(CdSystematicPhysicalExaminationDetail::class, 'cd_systematic_physical_examination_id');
    }

    // Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('cd_systematic_physical_examinations.spe_id', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('cd_systematic_physical_examinations.id')
            ->whereNull('cd_systematic_physical_examinations.deleted_at')
            ->latest()
            ->paginate(10);

        return $rtn;
    }

    // protected function validateRepeaterData($repeater_data)
    // {
    //     if (!is_array($repeater_data)) {
    //         throw ValidationException::withMessages([
    //             'kt_docs_repeater_advanced_spe' => ['Invalid data format']
    //         ]);
    //     }

    //     foreach ($repeater_data as $key => $value) {
    //         request()->validate([
    //             "kt_docs_repeater_advanced_spe.{$key}.selectSPE" => 'required|exists:systematic_physical_examinations,id',
    //             "kt_docs_repeater_advanced_spe.{$key}.selectSubSPE" => 'required|array|min:1',
    //             "kt_docs_repeater_advanced_spe.{$key}.selectSubSPE.*" => 'required|exists:systematic_physical_examinations,id',
    //         ], [
    //             "kt_docs_repeater_advanced_spe.{$key}.selectSPE.required" => 'The systematic physical examination is required',
    //             "kt_docs_repeater_advanced_spe.{$key}.selectSubSPE.required" => 'At least one sub-examination must be selected',
    //             "kt_docs_repeater_advanced_spe.{$key}.selectSubSPE.min" => 'At least one sub-examination must be selected',
    //         ]);
    //     }
    // }

    public function addForm($request = false)
    {
          $default_layout = getDefaultOPDDoctorLayout();
        switch ($default_layout) {
            case 'modern':
        try {
            $cd_id = request('cd_id');
            $tabName = 'spe';

            $validator = Validator::make(request()->all(), [
                'cd_id' => $cd_id,
                'kt_docs_repeater_advanced_spe.*.selectSPE' => [  'required' ],
                'kt_docs_repeater_advanced_spe.*.selectSubSPE' => ['required', 'array'],
            ], [
                'kt_docs_repeater_advanced_spe.*.selectSPE.required' => 'A Systematic Physical Examination (SPE) must be selected.',
                'kt_docs_repeater_advanced_spe.*.selectSubSPE.required' => 'At least one sub-SPE must be selected.',
                'kt_docs_repeater_advanced_spe.*.selectSubSPE.array' => 'The sub-SPE field must be an array.',
            ]);

            if ($validator->fails()) {
                return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                    ->withErrors($validator)
                    ->withInput();
            }

            $repeater_data = request('kt_docs_repeater_advanced_spe');

            foreach ($repeater_data as $value) {
                if (!array_key_exists('selectSPE', $value) || !array_key_exists('selectSubSPE', $value)) {
                    continue;
                }

                $matchThese = [
                    'spe_id' => $value['selectSPE'],
                    'cd_id' => $cd_id
                ];

                $obj = CdSystematicPhysicalExamination::updateOrCreate($matchThese, [
                    'created_by' => auth()->user()->id,
                    'remarks' => $value['remarks']
                ]);

                $cd_spe_id = $obj->id;

                if (is_array($value['selectSubSPE'])) {
                    foreach ($value['selectSubSPE'] as $selectSubSPEVal) {
                        if ($selectSubSPEVal === null) {
                            continue;
                        }

                        //Handle custom sub-SPEs
                        if (!is_numeric($selectSubSPEVal)) {
                            $customSPE = SystematicPhysicalExamination::create([
                                'name' => $selectSubSPEVal,
                                'verification_status' => 'pending',
                                'is_manual' => 1,
                                'parent_id' => $value['selectSPE'],
                                'created_by' => auth()->user()->id
                            ]);

                            $selectSubSPEVal = $customSPE->id; // Replace text with new ID
                        }

                        $matchThese = [
                            'cd_systematic_physical_examination_id' => (int) $cd_spe_id,
                            'spe_id' => (int) $selectSubSPEVal
                        ];

                        CdSystematicPhysicalExaminationDetail::updateOrCreate($matchThese, [
                            'created_by' => auth()->user()->id
                        ]);
                    }
                }


            }

            session()->flash('success', 'SPE added successfully.');
            $tabName = 'investigations';
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");


        } catch (\Exception $e) {
            session()->flash('error', 'Error processing SPE data: ' . $e->getMessage());
            return back();
        }
        break;

        case 'simple':
            try {
                $cd_id = request('cd_id');
                $tabName = 'spe';

                // Validation
                $validator = Validator::make(request()->all(), [
                      'cd_id' => $cd_id,
                    'kt_docs_repeater_advanced_spe.*.selectSubSPE' => 'required|array',
                    'kt_docs_repeater_advanced_spe.*.remarks' => 'nullable|string',
                ], [
                    'kt_docs_repeater_advanced_spe.*.selectSubSPE.required' => 'At least one sub-SPE must be selected.',
                    'kt_docs_repeater_advanced_spe.*.selectSubSPE.array' => 'Sub-SPE must be an array.',
                ]);

                if ($validator->fails()) {
                    return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                        ->withErrors($validator)
                        ->withInput();
                }

                $repeater_data = request('kt_docs_repeater_advanced_spe');

                foreach ($repeater_data as $entry) {
                    if (!isset($entry['selectSubSPE']) || !is_array($entry['selectSubSPE'])) {
                        continue;
                    }

                    $grouped = [];

                    foreach ($entry['selectSubSPE'] as $subId) {
                        if (!is_numeric($subId)) continue;

                        $child = SystematicPhysicalExamination::find($subId);
                        if (!$child || !$child->parent_id) continue;

                        $parentId = $child->parent_id;
                        $grouped[$parentId][] = $child->id;
                    }

                    foreach ($grouped as $parentId => $childIds) {
                        $obj = CdSystematicPhysicalExamination::updateOrCreate([
                            'cd_id' => $cd_id,
                            'spe_id' => $parentId,
                        ], [
                            'remarks' => $entry['remarks'] ?? null,
                            'created_by' => auth()->user()->id
                        ]);

                        foreach ($childIds as $childId) {
                            CdSystematicPhysicalExaminationDetail::updateOrCreate([
                                'cd_systematic_physical_examination_id' => $obj->id,
                                'spe_id' => $childId,
                            ], [
                                'created_by' => auth()->user()->id
                            ]);
                        }
                    }
                }

                session()->flash('success', 'SPE added successfully.');
                return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . '?tabName=investigations';

            } catch (\Exception $e) {
                session()->flash('error', 'Error processing simple SPE data: ' . $e->getMessage());
                return back();
            }
            break;

        case 'advanced':
            dd("advanced layout");
            break;
    }

    }


    public function updateForm()
    {
        $cd_id = request('cd_id');
         $default_layout = getDefaultOPDDoctorLayout(); // modern, simple, advanced (future)

      switch ($default_layout) {
        case 'modern':

      if ($cd_id) {
        if (!request()->has('kt_docs_repeater_advanced_spe')) {
            CdSystematicPhysicalExamination::where('cd_id', $cd_id)->delete();
            session()->flash('success', 'SPE data removed successfully');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=spe");
        }

        request()->validate([
            'cd_id' => request('cd_id'),
            'kt_docs_repeater_advanced_spe.*.selectSPE' => 'required',
            'kt_docs_repeater_advanced_spe.*.selectSubSPE' => 'required',
        ], [
            'kt_docs_repeater_advanced_spe.*.selectSPE.required' => 'A Systematic Physical Examination (SPE) must be selected',
            'kt_docs_repeater_advanced_spe.*.selectSubSPE.required' => 'At least one sub-SPE must be selected',
        ]);

        try {
            CdSystematicPhysicalExamination::where('cd_id', $cd_id)->delete();

            foreach (request('kt_docs_repeater_advanced_spe') as $value) {
                $selectSPE = $value['selectSPE'];
                $remarks = $value['remarks'] ?? null;

                // Restore or create SPE
                $spe = CdSystematicPhysicalExamination::withTrashed()
                    ->where('cd_id', $cd_id)
                    ->where('spe_id', $selectSPE)
                    ->first();

                if ($spe) {
                    $spe->restore();
                    $spe->remarks = $remarks;
                    $spe->updated_by = auth()->id();
                    $spe->save();
                } else {
                    $spe = CdSystematicPhysicalExamination::create([
                        'cd_id' => $cd_id,
                        'spe_id' => $selectSPE,
                        'remarks' => $remarks,
                        'created_by' => auth()->id()
                    ]);
                }

                // Soft delete existing sub-SPEs
                CdSystematicPhysicalExaminationDetail::where('cd_systematic_physical_examination_id', $spe->id)->delete();

                foreach ($value['selectSubSPE'] as $subSPE) {
                    // If it's a custom tag (not numeric), create new manual SPE
                    if (!is_numeric($subSPE)) {
                        $manualSPE = SystematicPhysicalExamination::updateOrCreate(
                            ['name' => $subSPE, 'parent_id' => $selectSPE],
                            [
                                'is_manual' => 1,
                                'verification_status' => 'pending',
                                'created_by' => auth()->id()
                            ]
                        );
                        $subSPEId = $manualSPE->id;
                    } else {
                        $subSPEId = $subSPE;
                    }

                    // Restore or create detail
                    $detail = CdSystematicPhysicalExaminationDetail::withTrashed()
                        ->where('cd_systematic_physical_examination_id', $spe->id)
                        ->where('spe_id', $subSPEId)
                        ->first();

                    if ($detail) {
                        $detail->restore();
                        $detail->updated_by = auth()->id();
                        $detail->save();
                    } else {
                        CdSystematicPhysicalExaminationDetail::create([
                            'cd_systematic_physical_examination_id' => $spe->id,
                            'spe_id' => $subSPEId,
                            'created_by' => auth()->id()
                        ]);
                    }
                }
            }
            session()->flash('success', 'SPE updated successfully');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=investigations");

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back();
        }
     }
          break;
            case 'simple':
            if ($cd_id) {
                if (!request()->has('kt_docs_repeater_advanced_spe')) {
                    CdSystematicPhysicalExamination::where('cd_id', $cd_id)->delete();
                    session()->flash('success', 'SPE data removed successfully');
                    return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=investigations");
                }

                request()->validate([
                    'cd_id' => request('cd_id'),
                     'kt_docs_repeater_advanced_spe.*.selectSubSPE' => 'required|array',
                    'kt_docs_repeater_advanced_spe.*.remarks' => 'nullable|string',
                ], [
                    'kt_docs_repeater_advanced_spe.*.selectSubSPE.required' => 'At least one sub-SPE must be selected',
                ]);

                try {
                    CdSystematicPhysicalExamination::where('cd_id', $cd_id)->delete();

                    foreach (request('kt_docs_repeater_advanced_spe') as $entry) {
                        if (!isset($entry['selectSubSPE']) || !is_array($entry['selectSubSPE'])) {
                            continue;
                        }

                        $remarks = $entry['remarks'] ?? null;
                        $groupedByParent = [];

                        foreach ($entry['selectSubSPE'] as $subSPE) {
                            if (!is_numeric($subSPE)) continue;

                            $child = SystematicPhysicalExamination::find($subSPE);
                            if (!$child || !$child->parent_id) continue;

                            $parentId = $child->parent_id;
                            $groupedByParent[$parentId][] = $child->id;
                        }

                        foreach ($groupedByParent as $parentId => $subIds) {
                            $spe = CdSystematicPhysicalExamination::create([
                                'cd_id' => $cd_id,
                                'spe_id' => $parentId,
                                'remarks' => $remarks,
                                'created_by' => auth()->user()->id
                            ]);

                            foreach ($subIds as $subId) {
                                CdSystematicPhysicalExaminationDetail::create([
                                    'cd_systematic_physical_examination_id' => $spe->id,
                                    'spe_id' => $subId,
                                    'created_by' => auth()->user()->id
                                ]);
                            }
                        }
                    }

                    session()->flash('success', 'SPE updated successfully');
                    return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=investigations");

                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());
                    return back();
                }
            } else {
                session()->flash('error', 'Invalid request: Missing cd_id');
                return back();
            }
            break;

        case 'advanced':
         dd("advanced layout");
            break;
    }
     }


    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'SPE deleted successfully',
        ]);
    }

    public static function getSPEData($cd_id)
    {
        $speData = CdSystematicPhysicalExamination::join('systematic_physical_examinations as spe', 'spe.id', 'cd_systematic_physical_examinations.spe_id')
            ->select([
                'cd_systematic_physical_examinations.id as cd_spe_id',
                'spe.name as spe_name',
                'spe.description as spe_description',
                'cd_systematic_physical_examinations.remarks as remarks',
            ])
            ->where('cd_systematic_physical_examinations.cd_id', $cd_id)
            ->get();

        foreach ($speData as $d) {
            $child_data = CdSystematicPhysicalExaminationDetail::join('systematic_physical_examinations as spe', 'spe.id', 'cd_systematic_physical_examination_details.spe_id')
                ->select([
                    'spe.name as spe_name',
                    'spe.description as spe_description',
                ])
                ->where('cd_systematic_physical_examination_details.cd_systematic_physical_examination_id', $d->cd_spe_id)
                ->get();

            $d->child_data = $child_data;
        }

        return $speData;
    }


}
