<?php

namespace App\Models;

use App\Models\CdComplaintDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdComplaint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['complaint_id', 'cd_id', 'duration', 'created_by', 'updated_by', 'deleted_by','remarks'];

    // Relationships
    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }

    public function clinicalDiagnosis()
    {
        return $this->belongsTo(ClinicalDiagnosis::class, 'cd_id');
    }

    public function cdComplaintDetails()
    {
        return $this->hasMany(CdComplaintDetail::class, 'cd_complaint_id');
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
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('cd_complaints.duration', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('cd_complaints.id')
            ->whereNull('cd_complaints.deleted_at')
            ->latest()
            ->paginate(10);

        return $rtn;
    }

    public function addForm()
    {
        $default_layout = getDefaultOPDDoctorLayout();
        switch ($default_layout) {
            case 'modern':
                try {
                        $tabName = 'vitals';
                        $cd_id = request('cd_id');

                        $repeater_data = request('kt_docs_repeater_advanced_complaints');
                        $validator = Validator::make(request()->all(), [
                            'cd_id' => $cd_id,
                            'kt_docs_repeater_advanced_complaints.*.duration' => ['nullable', 'numeric', 'min:0'],
                            'kt_docs_repeater_advanced_complaints.*.selectSymptom' => 'required',
                            'kt_docs_repeater_advanced_complaints.*.selectSubSymptom' => 'required|array',
                            'kt_docs_repeater_advanced_complaints.*.remarks' => 'nullable',

                        ], [
                            // 'kt_docs_repeater_advanced_complaints.*.duration.required' => 'Duration is required',
                            'kt_docs_repeater_advanced_complaints.*.duration.min' => 'Duration cannot be negative',
                            'kt_docs_repeater_advanced_complaints.*.selectSymptom.required' => 'Symptom is required',
                            'kt_docs_repeater_advanced_complaints.*.selectSubSymptom.required' => 'At least one sub-symptom is required',
                        ]);

                        if ($validator->fails()) {
                            return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id])
                                ->withErrors($validator)
                                ->withInput()
                                ->with('tabName', $tabName);
                        }

                        foreach ($repeater_data as $value) {
                            // Check if required fields exist in the repeater data
                            if (
                                !array_key_exists('selectSymptom', $value) ||
                                !array_key_exists('selectSubSymptom', $value) ||
                                !array_key_exists('duration', $value)
                            ) {
                                continue; // Skip this iteration if required fields are missing
                            }

                            $matchThese = [
                                'complaint_id' => $value['selectSymptom'],
                                'cd_id' => $cd_id
                            ];

                            $obj = CdComplaint::updateOrCreate($matchThese, [
                                'duration' => $value['duration'], // Add duration field here
                                'remarks' => $value['remarks'] ?? null,
                                'created_by' => auth()->user()->id
                            ]);

                            $cd_complaint_id = $obj->id;

                            // Ensure selectSubSymptom is an array before processing
                            if (is_array($value['selectSubSymptom'])) {
                                foreach ($value['selectSubSymptom'] as $subSymptomKey => $subSymptomVal) {
                                    if ($subSymptomVal === null) {
                                        continue; // Skip if sub-diagnosis value is not set
                                    }

                                    //Handle custom sub-Symptoms
                                    if (!is_numeric($subSymptomVal)) {
                                        $customComplaint = Complaint::create([
                                            'name' => $subSymptomVal,
                                            'verification_status' => 'pending',
                                            'is_manual' => 1,
                                            'parent_id' => $value['selectSymptom'],
                                            'created_by' => auth()->user()->id
                                        ]);

                                        $subSymptomVal = $customComplaint->id; // Replace text with new ID
                                    }

                                    $matchThese = [
                                        'cd_complaint_id' => (int)$cd_complaint_id,
                                        'complaint_id' => (int)$subSymptomVal
                                    ];

                                    $CdComplaintDetail = CdComplaintDetail::updateOrCreate($matchThese, [
                                        'created_by' => auth()->user()->id
                                    ]);
                                }
                            }
                        }

                        session()->flash('success', 'Patient complaint added successfully');
                        $tabName = 'vitals';
                        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");

                    } catch (\Exception $e) {
                        session()->flash('error', 'Error processing complaint data: ' . $e->getMessage());
                        return back();
                    }
            break;

       case 'simple':
             try {
        $tabName = 'vitals';
        $cd_id = request('cd_id');
        $repeater_data = request('kt_docs_repeater_advanced_complaints');

        $validator = Validator::make(request()->all(), [
            'cd_id' => $cd_id,
            'kt_docs_repeater_advanced_complaints.*.selectSubSymptom' => 'required|array',
            'kt_docs_repeater_advanced_complaints.*.duration' => 'nullable|numeric|min:0',
            'kt_docs_repeater_advanced_complaints.*.remarks' => 'nullable|string',
        ], [
            'kt_docs_repeater_advanced_complaints.*.selectSubSymptom.required' => 'At least one sub-symptom is required',
            'kt_docs_repeater_advanced_complaints.*.duration.min' => 'Duration cannot be negative',
        ]);

        if ($validator->fails()) {
            return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id])
                ->withErrors($validator)
                ->withInput()
                ->with('tabName', $tabName);
        }

        foreach ($repeater_data as $entry) {
            if (!isset($entry['selectSubSymptom']) || !is_array($entry['selectSubSymptom'])) {
                continue;
            }

            $groupedByParent = [];

            foreach ($entry['selectSubSymptom'] as $subSymptom) {
                if (!is_numeric($subSymptom)) continue;

                $childComplaint = Complaint::find($subSymptom);
                if (!$childComplaint || !$childComplaint->parent_id) continue;

                $parentId = $childComplaint->parent_id;
                $groupedByParent[$parentId][] = $childComplaint->id;
            }

            foreach ($groupedByParent as $parentId => $subSymptomIds) {
                $obj = CdComplaint::updateOrCreate([
                    'cd_id' => $cd_id,
                    'complaint_id' => $parentId,
                ], [
                    'duration' => $entry['duration'] ?? null,
                    'remarks' => $entry['remarks'] ?? null,
                    'created_by' => auth()->user()->id,
                ]);

                foreach ($subSymptomIds as $subId) {
                    CdComplaintDetail::updateOrCreate([
                        'cd_complaint_id' => $obj->id,
                        'complaint_id' => $subId,
                    ], [
                        'created_by' => auth()->user()->id,
                    ]);
                }
            }
        }

        session()->flash('success', 'Patient complaint added successfully');
        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");

        } catch (\Exception $e) {
        session()->flash('error', 'Error processing simple complaint data: ' . $e->getMessage());
        return back();
     }
      break;

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
            // If diagnosis data is empty (all entries removed), soft delete existing data
            if (!request()->has('kt_docs_repeater_advanced_complaints')) {
                CdComplaint::where('cd_id', $cd_id)->delete();
                session()->flash('success', 'Patient complaints data removed successfully');
                $tabName = 'vitals';
                return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
            }

            request()->validate([
                'cd_id' => request('cd_id'),
                'kt_docs_repeater_advanced_complaints.*.duration' => ['nullable', 'numeric', 'min:0'],
                'kt_docs_repeater_advanced_complaints.*.selectSymptom' => 'required',
                'kt_docs_repeater_advanced_complaints.*.selectSubSymptom' => 'required',
                'kt_docs_repeater_advanced_complaints.*.remarks' => 'nullable',
            ], [
                // 'kt_docs_repeater_advanced_complaints.*.duration.required' => 'Duration is required',
                'kt_docs_repeater_advanced_complaints.*.duration.min' => 'Duration cannot be negative',
                'kt_docs_repeater_advanced_complaints.*.selectSymptom.required' => 'Symptom is required',
                'kt_docs_repeater_advanced_complaints.*.selectSubSymptom.required' => 'At least one sub-symptom is required',
            ]);

            try {
                // First, soft delete all existing records
                CdComplaint::where('cd_id', $cd_id)->delete();

                $repeater_data = request('kt_docs_repeater_advanced_complaints');
                $submitted_complaints_ids = collect($repeater_data)->pluck('selectSymptom')->toArray();

                foreach ($repeater_data as $key => $value) {
                    // Check if record exists (including soft deleted)
                    $existing_complaint = CdComplaint::where('complaint_id', $value['selectSymptom'])
                        ->where('cd_id', $cd_id)
                        ->withTrashed()
                        ->first();

                      //    $parent_id = $value['selectSymptom'];
                      //    $complaint_sub_symptom = $value['selectSubSymptom'];
                        //    $complaint_sub_symptom_id = null;

                        //    if (isset($complaint_sub_symptom) && $complaint_sub_symptom != null){
                        //         if (is_numeric($$complaint_sub_symptom) == FALSE) {

                        //                 $new_complaint_obj = new Complaint;
                        //                 $new_complaint_obj->name = $complaint_sub_symptom;
                        //                 $new_complaint_obj->parent_id = $parent_id;
                        //                 $new_complaint_obj->status = 'pending';
                        //                 $new_complaint_obj->save();
                        //                 $complaint_sub_symptom_id(int)  = $new_complaint_obj->id;

                        //         } else {
                        //                 $complaint_sub_symptom_id(int) = $complaint_sub_symptom;
                        //         }

                        //    }

                    if ($existing_complaint) {
                        // Restore and update existing record
                        $existing_complaint->restore();
                        $existing_complaint->duration = $value['duration']; // Add duration update
                        $existing_complaint->remarks = $value['remarks'] ?? null;
                        $existing_complaint->updated_by = auth()->user()->id;
                        $existing_complaint->save();
                        $cd_complaint_id = $existing_complaint->id;
                    } else {



                        // Create new record
                        $new_complaint = CdComplaint::create([
                            'complaint_id' => $value['selectSymptom'],
                            'cd_id' => $cd_id,
                            'duration' => $value['duration'], // Add duration for new records
                            'remarks' => $value['remarks'] ?? null,
                            'created_by' => auth()->user()->id
                        ]);
                        $cd_complaint_id = $new_complaint->id;
                    }

                    // Handle sub-diagnoses
                    if (isset($value['selectSubSymptom']) && is_array($value['selectSubSymptom'])) {
                        // Soft delete existing sub-diagnoses
                        CdComplaintDetail::where('cd_complaint_id', $cd_complaint_id)->delete();

                        foreach ($value['selectSubSymptom'] as $subSymptomVal) {
                            if ($subSymptomVal === null) {
                                continue; // Skip if sub-diagnosis value is not set
                            }

                            if (!is_numeric($subSymptomVal)) {
                                $customComplaint = Complaint::updateOrCreate(
                                    ['name' => $subSymptomVal, 'parent_id' => $value['selectSymptom']],
                                    [
                                        'is_manual' => 1,
                                        'verification_status' => 'pending',
                                        'created_by' => auth()->id()
                                    ]
                                );
                                $subSymptomId = $customComplaint->id;
                            } else {
                                $subSymptomId  = $subSymptomVal;
                            }

                            // Check if sub-diagnosis exists
                            $existing_sub = CdComplaintDetail::where('cd_complaint_id', $cd_complaint_id)
                                ->where('complaint_id', $subSymptomId)
                                ->withTrashed()
                                ->first();

                            if ($existing_sub) {
                                // Restore and update existing sub-diagnosis
                                $existing_sub->restore();
                                $existing_sub->updated_by = auth()->user()->id;
                                $existing_sub->save();
                            } else {
                                // Create new sub-diagnosis
                                CdComplaintDetail::create([
                                    'cd_complaint_id' => $cd_complaint_id,
                                    'complaint_id' => $subSymptomId,
                                    'created_by' => auth()->user()->id
                                ]);
                            }
                        }
                    }
                }

                session()->flash('success', 'Patient complaint updated successfully');
                $tabName = 'vitals';
                return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");

            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
                return back();
            }
        } else {
            session()->flash('error', 'Invalid request: Missing cd_id');
            return back();
        }
             break;
              case 'simple':
         if ($cd_id) {
        if (!request()->has('kt_docs_repeater_advanced_complaints')) {
            CdComplaint::where('cd_id', $cd_id)->delete();
            session()->flash('success', 'Patient complaints data removed successfully');
            $tabName = 'vitals';
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }

        request()->validate([
            'cd_id' => request('cd_id'),
            'kt_docs_repeater_advanced_complaints.*.selectSubSymptom' => 'required|array',
            'kt_docs_repeater_advanced_complaints.*.duration' => 'nullable|numeric|min:0',
            'kt_docs_repeater_advanced_complaints.*.remarks' => 'nullable|string',
        ], [
            'kt_docs_repeater_advanced_complaints.*.selectSubSymptom.required' => 'At least one sub-symptom is required',
            'kt_docs_repeater_advanced_complaints.*.duration.min' => 'Duration cannot be negative',
        ]);

        try {
            CdComplaint::where('cd_id', $cd_id)->delete();

            $repeater_data = request('kt_docs_repeater_advanced_complaints');

            foreach ($repeater_data as $entry) {
                if (!isset($entry['selectSubSymptom']) || !is_array($entry['selectSubSymptom'])) {
                    continue;
                }

                $groupedByParent = [];

                foreach ($entry['selectSubSymptom'] as $subSymptom) {
                    if (!is_numeric($subSymptom)) continue;

                    $childComplaint = Complaint::find($subSymptom);
                    if (!$childComplaint || !$childComplaint->parent_id) continue;

                    $parentId = $childComplaint->parent_id;
                    $groupedByParent[$parentId][] = $childComplaint->id;
                }

                foreach ($groupedByParent as $parentId => $subSymptomIds) {
                    $obj = CdComplaint::updateOrCreate([
                        'cd_id' => $cd_id,
                        'complaint_id' => $parentId,
                    ], [
                        'duration' => $entry['duration'] ?? null,
                        'remarks' => $entry['remarks'] ?? null,
                        'created_by' => auth()->user()->id,
                    ]);

                    CdComplaintDetail::where('cd_complaint_id', $obj->id)->delete();

                    foreach ($subSymptomIds as $subId) {
                        CdComplaintDetail::updateOrCreate([
                            'cd_complaint_id' => $obj->id,
                            'complaint_id' => $subId,
                        ], [
                            'created_by' => auth()->user()->id,
                        ]);
                    }
                }
            }

            session()->flash('success', 'Patient complaint updated successfully');
            $tabName = 'vitals';
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");

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
            'message' => 'Complaint removed from clinical diagnosis successfully',
        ]);
    }


    public static function getComplaintsData($cd_id)
    {

        $complaintsData = \App\Models\CdComplaint::join('complaints as complaint', 'complaint.id', 'cd_complaints.complaint_id')
            ->select([
                'cd_complaints.id as cd_complaint_id',
                'complaint.name as complaint_name',
                'complaint.description as complaint_description',
                'cd_complaints.duration as complaint_duration',
                'cd_complaints.remarks as complaint_remarks',
            ])
            ->where('cd_complaints.cd_id', $cd_id)
            ->get();

        foreach ($complaintsData as $d) {
            $child_data = CdComplaintDetail::join('complaints as complaint', 'complaint.id', 'cd_complaint_details.complaint_id')
                ->select([
                    'complaint.name as complaint_name',
                    'complaint.description as complaint_description',
                ])
                ->where('cd_complaint_details.cd_complaint_id', $d->cd_complaint_id)
                ->get();

            $d->child_data = $child_data;
        }

        return $complaintsData;
    }


}
