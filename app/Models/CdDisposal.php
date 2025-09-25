<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\CdDoctor;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\ClinicalDiagnosis;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdDisposal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cd_disposal';

    protected $fillable = [
        'cd_id',
        'disposal_type',
        'disposal_type_id',
        'disposal_type_value',
        'dated',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function getReferredDoctorData ($cd_id) {

          $CdDisposal = CdDisposal::where('cd_id',$cd_id)->first();
          $CdDoctor = CdDoctor::where('cd_id',$cd_id)->orderBy('created_at', 'asc')->first();

          if ($CdDisposal) {

              $cd_disposal_type = $CdDisposal->disposal_type;
              $disposal_type = 'referred_to_specialist';

              if ($cd_disposal_type  ===  $disposal_type) {

                   $doctorData = Doctor::where('id',$CdDisposal->disposal_type_id)->first();
                   $disposalDoctorData = Doctor::where('id',$CdDoctor->doctor_id)->first();

                   $data['disposal_type'] = $CdDisposal->disposal_type;
                   $data['disposal_value'] = $CdDisposal->disposal_value;
                   $data['remarks'] = $CdDisposal->remarks;
                   $data['name'] = $doctorData->doctor_name;
                   $data['referred_from'] = $disposalDoctorData->doctor_name;

                   return $data;
              } else {

                   $data['name'] = null;
                   $data['referred_from'] = null;
                   $data['disposal_type'] = $CdDisposal->disposal_type ?? 'medical_advice';
                   $data['disposal_value'] = $CdDisposal->disposal_value ?? '';
                   $data['remarks'] = $CdDisposal->remarks;
                   return $data;
              }

          }
    }
    public function addForm()
    {
        $cd_id = request('cd_id');
         $validator = Validator::make(request()->all(), [
            'disposal_type' => 'required',
            'date' => 'required',
            'disposal_remarks' => 'nullable',
            'disposal_type_id' => 'nullable|required_if:disposal_type,referred_to_specialist|required_if:disposal_type,referred_to_department|required_if:disposal_type,referred_to_hospital',
            'disposal_type_value' => 'required_if:disposal_type,follow_up',
        ], [
            'disposal_type.required' => 'Please provide disposal type',
            'date.required' => 'Please provide disposal date',
            'disposal_type_value.required_if' => 'Please provide follow up date',
            'disposal_type_id.required_if' => match(request('disposal_type')){
                'referred_to_specialist' => 'Please select a specialist.',
                'referred_to_department' => 'Please select a department.',
                'referred_to_hospital' => 'Please select a hospital.',
                default => 'The disposal type id is required.',
            }
        ]);

        if ($validator->fails()) {
            return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => 'disposal'])
                ->withErrors($validator)
                ->withInput();
        }
        // $date = Carbon::createFromFormat('d/m/Y', request('date'))->format('Y-m-d');
        // try {
            $date = Carbon::createFromFormat('d/m/Y H:i', request('date'))->format('Y-m-d H:i:s');
            $disposal_type_value = null;
            if (request('disposal_type') === 'follow_up' && request('disposal_type_value')) {
                $disposal_type_value = Carbon::createFromFormat('d/m/Y h:i A',request('disposal_type_value'))->format('Y-m-d H:i:s');
            }

            if ($cd_id) {

                $matchThese = ['cd_id' => $cd_id];
                $obj = CdDisposal::updateOrCreate(
                    $matchThese,
                    [
                        'disposal_type' => request('disposal_type'),
                        'disposal_type_id' => request('disposal_type_id'),
                        'disposal_type_value' => $disposal_type_value,
                        'dated' => $date,
                        'remarks' => request('disposal_remarks'),
                        'updated_by' => auth()->user()->id,
                        'created_by' => auth()->user()->id,
                    ]
                );

                if (request('disposal_type') == 'referred_to_specialist') {

                    $matchThese = ['cd_id' => $cd_id];
                    CdDoctor::create(
                        [
                            'cd_id' => $cd_id,
                            'doctor_id' => $obj->disposal_type_id,
                            'disposal_type_id' => request('disposal_type_id'),
                            'start_date' => $date,
                            'end_date' => $date,
                            'updated_by' => auth()->user()->id,
                            'created_by' => auth()->user()->id,
                        ]
                    );
                }
            }

            session()->flash('success', 'Disposal added successfully');

            $doctorPanelValue = checkDoctorPanelVal();
            if ($doctorPanelValue) {
                $adv = ClinicalDiagnosis::find($cd_id);

                if (request('disposal_type') === 'referred_to_specialist') {
                    $adv->status = 'referred';
                    $adv->update();
                } else {
                    $adv->status = 'completed';
                    $adv->update();
                }

                // return redirect(route('clinical_diagnosis.myDailyListingRecord'));
                $tabName = 'disposal';
                return  redirect(route('clinical_diagnosis.myDailyListingRecord'));
                // return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
            }

            $tabName = 'disposal';
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");

        // } catch (\Exception $e) {
        // return back()->with('error', 'Error occurred while performing this action, please fill out your form properly')->withInput();
    // }
    }
}


