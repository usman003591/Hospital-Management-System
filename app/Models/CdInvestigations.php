<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdInvestigations extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cd_id',
        'investigation_id',
        'investigation_type_id',
        'remarks',
        'barcode',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function cd()
    {
        return $this->belongsTo(ClinicalDiagnosis::class);
    }

    public function investigation()
    {
        return $this->belongsTo(Investigations::class);
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getInvestigationsData($cd_id, $investigation_type_id)
    {
        $investigationsData = CdInvestigations::join('investigations as inves', 'inves.id', 'cd_investigations.investigation_id')
            ->select([
                'inves.name as investigation_name',
                'inves.description as investigation_description',
                'inves.type_id as investigation_type_id',
                 'inves.id as investigation_id'
            ])
            ->where('cd_id', $cd_id)
            ->where('inves.type_id', $investigation_type_id)
            ->get();

        return $investigationsData;
    }

    public static function getAll()
    {
        $request = request();
        $search['q'] = $request->has('q') ? $request->get('q') : false;
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
        request()->validate([
            'cd_id' => $cd_id,
            'kt_docs_repeater_advanced_radiology.*.radiology' => ['nullable', 'sometimes'],
            'kt_docs_repeater_advanced_pathology.*.pathology' => ['sometimes', 'nullable'],
            'kt_docs_repeater_advanced_rehablitation.*.rehablitation' => ['sometimes', 'nullable'],
            'kt_docs_repeater_advanced_radiology.*.remarks' => ['nullable', 'sometimes'],
            'kt_docs_repeater_advanced_pathology.*.remarks' => ['sometimes', 'nullable'],
            'kt_docs_repeater_advanced_rehablitation.*.remarks' => ['sometimes', 'nullable'],
        ]);

        $tabName = 'diagnosis';

        if (null === $cd_id) {
            session()->flash('error', 'Clinical Diagnosis ID is required');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }

        $hasData = false;

        // ------------------- Radiology -------------------
        $repeater_data = request('kt_docs_repeater_advanced_radiology');
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 1)->update(['deleted_by' => auth()->user()->id]);
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 1)->delete();

        if (isset($repeater_data)) {
            foreach ($repeater_data as $value) {
                $radiologyId = $value['radiology'];
                if (!isset($radiologyId))
                    continue;

                // Create custom tag if needed
                if (!is_numeric($radiologyId)) {
                    $newRadiology = Investigations::create([
                        'name' => $radiologyId,
                        'type_id' => 1,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);
                    $radiologyId = $newRadiology->id;
                }

                $hasData = true;
                $existing = CdInvestigations::withTrashed()
                    ->where('cd_id', $cd_id)
                    ->where('investigation_id', $radiologyId)
                    ->where('investigation_type_id', 1)
                    ->first();

                if ($existing) {
                    $existing->restore();
                    $existing->update([
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'updated_by' => auth()->user()->id
                    ]);
                } else {
                    CdInvestigations::create([
                        'cd_id' => $cd_id,
                        'investigation_id' => $radiologyId,
                        'investigation_type_id' => 1,
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'created_by' => auth()->user()->id
                    ]);
                }
            }
        }

        // ------------------- Pathology -------------------
        $repeater_data = request('kt_docs_repeater_advanced_pathology');
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 2)->update(['deleted_by' => auth()->user()->id]);
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 2)->delete();

        if (isset($repeater_data)) {
            foreach ($repeater_data as $value) {
                $pathologyId = $value['pathology'];
                if (!isset($pathologyId))
                    continue;

                if (!is_numeric($pathologyId)) {
                    $newPathology = Investigations::create([
                        'name' => $pathologyId,
                        'type_id' => 2,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);
                    $pathologyId = $newPathology->id;
                }

                $hasData = true;
                $existing = CdInvestigations::withTrashed()
                    ->where('cd_id', $cd_id)
                    ->where('investigation_id', $pathologyId)
                    ->where('investigation_type_id', 2)
                    ->first();

                if ($existing) {
                    $existing->restore();
                    $existing->update([
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'updated_by' => auth()->user()->id
                    ]);
                } else {
                    CdInvestigations::create([
                        'cd_id' => $cd_id,
                        'investigation_id' => $pathologyId,
                        'investigation_type_id' => 2,
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'created_by' => auth()->user()->id
                    ]);
                }
            }
        }

        // ------------------- Rehabilitation -------------------
        $repeater_data = request('kt_docs_repeater_advanced_rehablitation');
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 3)->update(['deleted_by' => auth()->user()->id]);
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 3)->delete();

        if (isset($repeater_data)) {
            foreach ($repeater_data as $value) {
                $rehabId = $value['rehablitation'];
                if (!isset($rehabId))
                    continue;

                if (!is_numeric($rehabId)) {
                    $newRehab = Investigations::create([
                        'name' => $rehabId,
                        'type_id' => 3,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);
                    $rehabId = $newRehab->id;
                }

                $hasData = true;
                $existing = CdInvestigations::withTrashed()
                    ->where('cd_id', $cd_id)
                    ->where('investigation_id', $rehabId)
                    ->where('investigation_type_id', 3)
                    ->first();

                if ($existing) {
                    $existing->restore();
                    $existing->update([
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'updated_by' => auth()->user()->id
                    ]);
                } else {
                    CdInvestigations::create([
                        'cd_id' => $cd_id,
                        'investigation_id' => $rehabId,
                        'investigation_type_id' => 3,
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'created_by' => auth()->user()->id
                    ]);
                }
            }
        }

        if (!$hasData) {
            session()->flash('warning', 'No investigation data entered');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }

        session()->flash('success', 'Investigation added successfully');
        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
    }

    public function updateForm()
    {
        $cd_id = request('cd_id');
        request()->validate([
            'cd_id' => $cd_id,
            'kt_docs_repeater_advanced_radiology.*.radiology' => ['nullable', 'sometimes'],
            'kt_docs_repeater_advanced_pathology.*.pathology' => ['sometimes', 'nullable'],
            'kt_docs_repeater_advanced_rehablitation.*.rehablitation' => ['sometimes', 'nullable'],
            'kt_docs_repeater_advanced_radiology.*.remarks' => ['nullable', 'sometimes'],
            'kt_docs_repeater_advanced_pathology.*.remarks' => ['sometimes', 'nullable'],
            'kt_docs_repeater_advanced_rehablitation.*.remarks' => ['sometimes', 'nullable'],
        ]);

        $tabName = 'diagnosis';

        if (null === $cd_id) {
            session()->flash('error', 'Clinical Diagnosis ID is required');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }

        $hasData = false;

        // ------------------- Radiology -------------------
        $repeater_data = request('kt_docs_repeater_advanced_radiology');
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 1)->update(['deleted_by' => auth()->user()->id]);
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 1)->delete();

        if (isset($repeater_data)) {
            foreach ($repeater_data as $value) {
                $radiologyId = $value['radiology'];
                if (!isset($radiologyId))
                    continue;

                // Create custom tag if needed
                if (!is_numeric($radiologyId)) {
                    $newRadiology = Investigations::create([
                        'name' => $radiologyId,
                        'type_id' => 1,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);
                    $radiologyId = $newRadiology->id;
                }

                $hasData = true;
                $existing = CdInvestigations::withTrashed()
                    ->where('cd_id', $cd_id)
                    ->where('investigation_id', $radiologyId)
                    ->where('investigation_type_id', 1)
                    ->first();

                if ($existing) {
                    $existing->restore();
                    $existing->update([
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'updated_by' => auth()->user()->id
                    ]);
                } else {
                    CdInvestigations::create([
                        'cd_id' => $cd_id,
                        'investigation_id' => $radiologyId,
                        'investigation_type_id' => 1,
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'created_by' => auth()->user()->id
                    ]);
                }
            }
        }

        // ------------------- Pathology -------------------
        $repeater_data = request('kt_docs_repeater_advanced_pathology');
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 2)->update(['deleted_by' => auth()->user()->id]);
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 2)->delete();

        if (isset($repeater_data)) {
            foreach ($repeater_data as $value) {
                $pathologyId = $value['pathology'];
                if (!isset($pathologyId))
                    continue;

                if (!is_numeric($pathologyId)) {
                    $newPathology = Investigations::create([
                        'name' => $pathologyId,
                        'type_id' => 2,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);
                    $pathologyId = $newPathology->id;
                }

                $hasData = true;
                $existing = CdInvestigations::withTrashed()
                    ->where('cd_id', $cd_id)
                    ->where('investigation_id', $pathologyId)
                    ->where('investigation_type_id', 2)
                    ->first();

                if ($existing) {
                    $existing->restore();
                    $existing->update([
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'updated_by' => auth()->user()->id
                    ]);
                } else {
                    CdInvestigations::create([
                        'cd_id' => $cd_id,
                        'investigation_id' => $pathologyId,
                        'investigation_type_id' => 2,
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'created_by' => auth()->user()->id
                    ]);
                }
            }
        }

        // ------------------- Rehabilitation -------------------
        $repeater_data = request('kt_docs_repeater_advanced_rehablitation');
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 3)->update(['deleted_by' => auth()->user()->id]);
        CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 3)->delete();

        if (isset($repeater_data)) {
            foreach ($repeater_data as $value) {
                $rehabId = $value['rehablitation'];
                if (!isset($rehabId))
                    continue;

                if (!is_numeric($rehabId)) {
                    $newRehab = Investigations::create([
                        'name' => $rehabId,
                        'type_id' => 3,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);
                    $rehabId = $newRehab->id;
                }

                $hasData = true;
                $existing = CdInvestigations::withTrashed()
                    ->where('cd_id', $cd_id)
                    ->where('investigation_id', $rehabId)
                    ->where('investigation_type_id', 3)
                    ->first();

                if ($existing) {
                    $existing->restore();
                    $existing->update([
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'updated_by' => auth()->user()->id
                    ]);
                } else {
                    CdInvestigations::create([
                        'cd_id' => $cd_id,
                        'investigation_id' => $rehabId,
                        'investigation_type_id' => 3,
                        'barcode' => 'Temp',
                        'remarks' => $value['remarks'],
                        'created_by' => auth()->user()->id
                    ]);
                }
            }
        }

        if (!$hasData) {
            session()->flash('warning', 'No investigation data entered');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }

        session()->flash('success', 'Investigation updated successfully');
        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Clinical diagnosis investigation has been deleted successfully',
        ]);
    }
}
