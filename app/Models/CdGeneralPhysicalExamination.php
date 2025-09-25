<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\GeneralPhysicalExamination;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CdGeneralPhysicalExaminationDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdGeneralPhysicalExamination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['gpe_id', 'cd_id', 'remarks', 'created_by', 'updated_by', 'deleted_by'];

    // Relationships
    public function generalPhysicalExamination()
    {
        return $this->belongsTo(GeneralPhysicalExamination::class, 'gpe_id');
    }

    public function clinicalDiagnosis()
    {
        return $this->belongsTo(ClinicalDiagnosis::class, 'cd_id');
    }

    public function cdGeneralPhysicalExaminationDetails()
    {
        return $this->hasMany(CdGeneralPhysicalExaminationDetail::class, 'cd_gpe_id');
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
            $data = $data->where('cd_general_physical_examinations.gpe_id', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('cd_general_physical_examinations.id')
            ->whereNull('cd_general_physical_examinations.deleted_at')
            ->latest()
            ->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
           $default_layout = getDefaultOPDDoctorLayout();
        switch ($default_layout) {
            case 'modern':
        try {
            $cd_id = request('cd_id');
             $layout = request()->route('layout'); 
            $tabName = 'gpe';

            $validator = Validator::make(request()->all(), [
                'cd_id' => $cd_id,
                'kt_docs_repeater_advanced_gpe.*.selectGPE' =>'required',
                'kt_docs_repeater_advanced_gpe.*.selectSubGPE' => 'required|array',
            ], [
                'kt_docs_repeater_advanced_gpe.*.selectGPE.required' => 'A General Physical Examination (GPE) must be selected',
                'kt_docs_repeater_advanced_gpe.*.selectSubGPE.required' => 'At least one sub-GPE must be selected',
                'kt_docs_repeater_advanced_gpe.*.selectSubGPE.array' => 'The sub-GPE field must be an array',
                'kt_docs_repeater_advanced_gpe.*.selectSubGPE.*.required' => 'Each sub-GPE selection is required',
            ]);

            if ($validator->fails()) {
                return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                    ->withErrors($validator)
                    ->withInput();
            }

            $repeater_data = request('kt_docs_repeater_advanced_gpe');

            foreach ($repeater_data as $key => $value) {
                if (!array_key_exists('selectGPE', $value) || !array_key_exists('selectSubGPE', $value)) {
                    continue;
                }

                $matchThese = [
                    'gpe_id' => $value['selectGPE'],
                    'cd_id' => $cd_id
                ];

                $obj = CdGeneralPhysicalExamination::updateOrCreate($matchThese, [
                    'created_by' => auth()->user()->id,
                    'remarks' => $value['remarks']
                ]);

                $cd_gpe_id = $obj->id;

                if (is_array($value['selectSubGPE'])) {
                    foreach ($value['selectSubGPE'] as $selectSubGPEKey => $selectSubGPEVal) {
                        if ($selectSubGPEVal === null) {
                            continue;
                        }

                        //Handle custom sub-GPEs
                        if (!is_numeric($selectSubGPEVal)) {
                            $customGPE = GeneralPhysicalExamination::create([
                                'name' => $selectSubGPEVal,
                                'verification_status' => 'pending',
                                'is_manual' => 1,
                                'parent_id' => $value['selectGPE'],
                                'created_by' => auth()->user()->id
                            ]);

                            $selectSubGPEVal = $customGPE->id; // Replace text with new ID
                        }

                        $matchThese = [
                            'cd_gpe_id' => (int) $cd_gpe_id,
                            'gpe_id' => (int) $selectSubGPEVal
                        ];

                        CdGeneralPhysicalExaminationDetail::updateOrCreate($matchThese, [
                            'created_by' => auth()->user()->id
                        ]);
                    }
                }
            }

            session()->flash('success', 'GPE added successfully');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=spe");

        } catch (\Exception $e) {
            session()->flash('error', 'Error processing GPE data: ' . $e->getMessage());
            return back();
        }
        break;
         case 'simple':
            try {
                $cd_id = request('cd_id');
                $tabName = 'gpe';

                $validator = Validator::make(request()->all(), [
                 'cd_id' => $cd_id,                   
                 'kt_docs_repeater_advanced_gpe.*.selectSubGPE' => 'required|array',
                 'kt_docs_repeater_advanced_gpe.*.remarks' => 'nullable|string',
                ], [
                    'kt_docs_repeater_advanced_gpe.*.selectSubGPE.required' => 'At least one sub-GPE must be selected',
                    'kt_docs_repeater_advanced_gpe.*.selectSubGPE.array' => 'Sub-GPE must be an array',
                ]);

                if ($validator->fails()) {
                    return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                        ->withErrors($validator)
                        ->withInput();
                }

                $repeater_data = request('kt_docs_repeater_advanced_gpe');

                foreach ($repeater_data as $entry) {
                    if (!isset($entry['selectSubGPE']) || !is_array($entry['selectSubGPE'])) {
                        continue;
                    }

                    $grouped = [];

                    foreach ($entry['selectSubGPE'] as $subId) {
                        if (!is_numeric($subId)) continue;

                        $child = GeneralPhysicalExamination::find($subId);
                        if (!$child || !$child->parent_id) continue;

                        $parentId = $child->parent_id;
                        $grouped[$parentId][] = $child->id;
                    }

                    foreach ($grouped as $parentId => $childIds) {
                        $obj = CdGeneralPhysicalExamination::updateOrCreate([
                            'cd_id' => $cd_id,
                            'gpe_id' => $parentId,
                        ], [
                            'remarks' => $entry['remarks'] ?? null,
                            'created_by' => auth()->user()->id
                        ]);

                        foreach ($childIds as $childId) {
                            CdGeneralPhysicalExaminationDetail::updateOrCreate([
                                'cd_gpe_id' => $obj->id,
                                'gpe_id' => $childId,
                            ], [
                                'created_by' => auth()->user()->id
                            ]);
                        }
                    }
                }

                session()->flash('success', 'GPE added successfully');
                return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=spe");

            } catch (\Exception $e) {
                session()->flash('error', 'Error processing simple GPE data: ' . $e->getMessage());
                return back();
            }
            break;
            case 'advanced':
            dd("advanced layout");
            break;
        }

    }


    public function updateForm($request = false)
{
    $cd_id = request('cd_id');
    $default_layout = getDefaultOPDDoctorLayout();

    
    switch ($default_layout) {
        case 'modern':
    if ($cd_id) {
        if (!request()->has('kt_docs_repeater_advanced_gpe')) {
            CdGeneralPhysicalExamination::where('cd_id', $cd_id)->delete();
            session()->flash('success', 'GPE data removed successfully');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=gpe");
        }

        request()->validate([
            'cd_id' => request('cd_id'),
            'kt_docs_repeater_advanced_gpe.*.selectGPE' =>'required',
            'kt_docs_repeater_advanced_gpe.*.selectSubGPE' => 'required',
        ], [
            'kt_docs_repeater_advanced_gpe.*.selectGPE.required' => 'A General Physical Examination (GPE) must be selected',
            'kt_docs_repeater_advanced_gpe.*.selectSubGPE.required' => 'At least one sub-GPE must be selected',
        ]);

        try {
            CdGeneralPhysicalExamination::where('cd_id', $cd_id)->delete();

            foreach (request('kt_docs_repeater_advanced_gpe') as $value) {
                $selectGPE = $value['selectGPE'];
                $remarks = $value['remarks'] ?? null;

                // Restore or create GPE
                $gpe = CdGeneralPhysicalExamination::withTrashed()
                    ->where('cd_id', $cd_id)
                    ->where('gpe_id', $selectGPE)
                    ->first();

                if ($gpe) {
                    $gpe->restore();
                    $gpe->remarks = $remarks;
                    $gpe->updated_by = auth()->id();
                    $gpe->save();
                } else {
                    $gpe = CdGeneralPhysicalExamination::create([
                        'cd_id' => $cd_id,
                        'gpe_id' => $selectGPE,
                        'remarks' => $remarks,
                        'created_by' => auth()->id()
                    ]);
                }

                // Soft delete existing sub-GPEs
                CdGeneralPhysicalExaminationDetail::where('cd_gpe_id', $gpe->id)->delete();

                foreach ($value['selectSubGPE'] as $subGPE) {
                    // If it's a custom tag (not numeric), create new manual GPE
                    if (!is_numeric($subGPE)) {
                        $manualGPE = GeneralPhysicalExamination::updateOrCreate(
                            ['name' => $subGPE, 'parent_id' => $selectGPE],
                            [
                                'is_manual' => 1,
                                'verification_status' => 'pending',
                                'created_by' => auth()->id()
                            ]
                        );
                        $subGPEId = $manualGPE->id;
                    } else {
                        $subGPEId = $subGPE;
                    }

                    // Restore or create detail
                    $detail = CdGeneralPhysicalExaminationDetail::withTrashed()
                        ->where('cd_gpe_id', $gpe->id)
                        ->where('gpe_id', $subGPEId)
                        ->first();

                    if ($detail) {
                        $detail->restore();
                        $detail->updated_by = auth()->id();
                        $detail->save();
                    } else {
                        CdGeneralPhysicalExaminationDetail::create([
                            'cd_gpe_id' => $gpe->id,
                            'gpe_id' => $subGPEId,
                            'created_by' => auth()->id()
                        ]);
                    }
                }
            }

            session()->flash('success', 'GPE updated successfully');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=spe");

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back();
        }
    }

    session()->flash('error', 'Invalid request: Missing cd_id');
    return back();
    break;
    
      case 'simple':
            if ($cd_id) {
                if (!request()->has('kt_docs_repeater_advanced_gpe')) {
                    CdGeneralPhysicalExamination::where('cd_id', $cd_id)->delete();
                    session()->flash('success', 'GPE data removed successfully');
                    return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=spe");
                }

                request()->validate([
                    'cd_id' => request('cd_id'),
                    'kt_docs_repeater_advanced_gpe.*.selectSubGPE' => 'required|array',
                    'kt_docs_repeater_advanced_gpe.*.remarks' => 'nullable|string',
                ], [
                    'kt_docs_repeater_advanced_gpe.*.selectSubGPE.required' => 'At least one sub-GPE must be selected',
                ]);

                try {
                    CdGeneralPhysicalExamination::where('cd_id', $cd_id)->delete();

                    foreach (request('kt_docs_repeater_advanced_gpe') as $entry) {
                        if (!isset($entry['selectSubGPE']) || !is_array($entry['selectSubGPE'])) {
                            continue;
                        }

                        $remarks = $entry['remarks'] ?? null;
                        $groupedByParent = [];

                        foreach ($entry['selectSubGPE'] as $subGPE) {
                            if (!is_numeric($subGPE)) continue;

                            $child = GeneralPhysicalExamination::find($subGPE);
                            if (!$child || !$child->parent_id) continue;

                            $parentId = $child->parent_id;
                            $groupedByParent[$parentId][] = $child->id;
                        }

                        foreach ($groupedByParent as $parentId => $subIds) {
                            $gpe = CdGeneralPhysicalExamination::create([
                                'cd_id' => $cd_id,
                                'gpe_id' => $parentId,
                                'remarks' => $remarks,
                                'created_by' => auth()->user()->id
                            ]);

                            foreach ($subIds as $subId) {
                                CdGeneralPhysicalExaminationDetail::create([
                                    'cd_gpe_id' => $gpe->id,
                                    'gpe_id' => $subId,
                                    'created_by' => auth()->user()->id
                                ]);
                            }
                        }
                    }

                    session()->flash('success', 'GPE updated successfully');
                    return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=spe");

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
            dd('advanced layout');
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
            'message' => 'General physical examination record for clinical diagnosis deleted successfully',
        ]);
    }

    public static function getGPEData($cd_id)
    {
        $gpeData = CdGeneralPhysicalExamination::join('general_physical_examinations as gpe', 'gpe.id', 'cd_general_physical_examinations.gpe_id')
            ->select([
                'cd_general_physical_examinations.id as cd_gpe_id',
                'gpe.name as gpe_name',
                'gpe.description as gpe_description',
                'cd_general_physical_examinations.remarks as remarks',
            ])
            ->where('cd_general_physical_examinations.cd_id', $cd_id)
            ->get();

        foreach ($gpeData as $d) {
            $child_data = CdGeneralPhysicalExaminationDetail::join('general_physical_examinations as gpe', 'gpe.id', 'cd_general_physical_examination_details.gpe_id')
                ->select([
                    'gpe.name as gpe_name',
                    'gpe.description as gpe_description',
                ])
                ->where('cd_general_physical_examination_details.cd_gpe_id', $d->cd_gpe_id)
                ->get();

            $d->child_data = $child_data;
        }

        return $gpeData;
    }

}
