<?php

namespace App\Models;

use Response;
use App\Models\Vital;
use App\Models\Doctor;
use App\Models\CdVital;
use App\Models\Patient;
use App\Models\CdDoctor;
use App\Models\CdDisposal;
use App\Models\Department;
use App\Models\CdComplaint;
use App\Models\CdDiagnosis;
use App\Models\CdTreatment;
use Illuminate\Support\Str;
use App\Models\CdBriefHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use App\Models\CdComplaintDetail;
use App\Models\ClinicalDiagnosis;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use App\Models\CdGeneralPhysicalExamination;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CdSystematicPhysicalExamination;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdSnapHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cd_id',
        'cd_mtabs_string',
        'snap_file_name',
        'snap_file_complete_path',
        'unique_identifier',
        'is_printed',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_printed' => 'boolean',
    ];

    public function cd()
    {
        return $this->belongsTo(ClinicalDiagnosis::class);
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getSnapshotsDir()
    {
        return 'assets/snapshots/';
    }

    public function generateSnapShot()
    {

        request()->validate([
            'cd_id' => request('cd_id'),
            'values' => 'required',
        ], );

        $module_values = request('values');
        $cd_id = request('cd_id');

        // try {

            $obj = ClinicalDiagnosis::find($cd_id);
            $hospital = Hospital::find($obj->hospital_id);
            $patient = Patient::find($obj->patient_id);
            $doctor_info = CdDoctor::where('cd_id', $cd_id)->first();

            if ($doctor_info) {
               $doctor_data = Doctor::withTrashed()->where('id',$doctor_info->doctor_id)->where('is_specialist', true)->first();
               $department_data = $doctor_data ? Department::find($doctor_data->department_id) : null;
            } else {
                $doctor_data = null;
                $department_data = null;
            }


            $cdCdBriefHistory = CdBriefHistory::where('cd_id', $cd_id)->first();
            $CdVital = CdVital::where('cd_id', $cd_id)->get();
            $vitals = Vital::getActiveVitals();
            $treatment_data = CdTreatment::getTreatmentData($cd_id);

            if($treatment_data->isEmpty()){
                $treatment_data = null;
            }

            $investigationsRadiologyData = CdInvestigations::getInvestigationsData($cd_id,1); //3
            $investigationsPathologyData = CdInvestigations::getInvestigationsData($cd_id,2); //2
            $investigationsRehablitationData = CdInvestigations::getInvestigationsData($cd_id,3);//1

            $overAllLength = 3;

            $minRadiologyInvestigations = count($investigationsRadiologyData);
            $minInvestigationsPathology = count($investigationsPathologyData);
            $minInvestigationsRehablitation = count($investigationsRehablitationData);

            $maxNumber = max($minRadiologyInvestigations, $minInvestigationsPathology, $minInvestigationsRehablitation);

            if ($maxNumber >= $overAllLength) {
                $overAllLength = $maxNumber;
            }

            $fillableRadiologyInvestigations =  $overAllLength - $minRadiologyInvestigations;
            $fillablePathologyInvestigations =  $overAllLength - $minInvestigationsPathology;
            $fillableRehablitationInvestigations =  $overAllLength - $minInvestigationsRehablitation;

            $updatedVitalData = [];

            foreach ($vitals as $item) {
                foreach ($CdVital as $updatedItem) {
                    if ($item->id == $updatedItem->vital_id) {
                        if ($item->is_boolean) {
                            if ($updatedItem->value == true) {
                                $item->value = 'Yes';
                            } elseif ($updatedItem->value == false) {
                                $item->value = 'No';
                            }
                        } else {
                            if (isset($updatedItem->value)) {
                                $item->value = $updatedItem->value;
                            } else {
                                $item->value = '&nbsp;';
                            }
                        }
                    }
                }

                $updatedVitalData[] = $item;
            }

            // dd( $updatedVitalData);


            if ($CdVital->isEmpty()) {
                $CdVital = null;
            }

            $cdComplaintData = CdComplaint::getComplaintsData($cd_id);
            if($cdComplaintData->isEmpty()){
                $cdComplaintData = null;
            }

            $cdDiagnosisData = CdDiagnosis::getDiagnosisData($cd_id);
            if($cdDiagnosisData->isEmpty()){
                $cdDiagnosisData = null;
            }

            $cdGPEData = CdGeneralPhysicalExamination::getGPEData($cd_id);
            if($cdGPEData->isEmpty()){
                $cdGPEData = null;
            }


            $cdSPEData = CdSystematicPhysicalExamination::getSPEData($cd_id);
            if($cdSPEData->isEmpty()){
                $cdSPEData = null;
            }

            $referredData = CdDisposal::getReferredDoctorData($cd_id);

            $disposalData = CdDisposal::where('cd_id',$cd_id)->first();

            $Snapobj = new CdSnapHistory;
            $Snapobj->cd_id = $cd_id;
            $Snapobj->cd_mtabs_string = '';
            $Snapobj->snap_file_name = '';
            $Snapobj->snap_file_complete_path = '';
            $Snapobj->created_by = auth()->user()->id;
            $Snapobj->save();

            $snap_history_unique_identifier = 'OPD-'.rand ( 1000 , 9999 ).'-'.$obj->id.'-'.$Snapobj->id;
            $Snapobj->unique_identifier = $snap_history_unique_identifier;
            $Snapobj->update();

            $button_url = route('clinical_diagnosis.downlaod_snapshot',['sanpshot_unique_number'=>$Snapobj->unique_identifier]);
            //generating QR code
            $qrCode = \QrCode::size(300)->generate($button_url); // Replace with your URL or data

            $customPaper = array(0, 0, 700, 1000);
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.prescriptions.snap_shot_fixed_version', compact(
                    'patient',
                    'doctor_data',
                    'department_data',
                    'cdCdBriefHistory',
                    'cdComplaintData',
                    'cdDiagnosisData',
                    'obj',
                    'vitals',
                    'updatedVitalData',
                    'treatment_data',
                    'module_values',
                    'investigationsRadiologyData',
                    'investigationsPathologyData',
                    'investigationsRehablitationData',
                    'fillableRadiologyInvestigations',
                    'fillablePathologyInvestigations',
                    'fillableRehablitationInvestigations',
                    'cdGPEData',
                    'cdSPEData',
                    'snap_history_unique_identifier',
                    'hospital',
                    'qrCode',
                    'referredData',
                    'disposalData'
              ))
              ->setPaper($customPaper, 'portrait');

            $dir = self::getSnapshotsDir();
            $extension = 'pdf';
            $FileName = strtolower(time() . '_' . rand(1000, 9999) . '.' . $extension);
            $path = public_path() . '/' . $dir;
            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            $pdf->save($path . $FileName);

            $file = $path . $FileName;
            $Snapobj->snap_file_name = $FileName;
            $Snapobj->snap_file_complete_path = $file;
            $Snapobj->created_by = auth()->user()->id;
            $Snapobj->update();

            $headers = array(
                'Content-Type: application/pdf',
            );

            return response()->stream(function () use ($file) {
                readfile($file);
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($file) . '"',
            ]);

        // } catch (\Exception $e) {
        //     return $e->getMessage();
        // }
    }

    public function downloadSnapFromUrl($sanpshot_unique_number) {
        $sanpObj = CdSnapHistory::where('unique_identifier',$sanpshot_unique_number)->first();
        if ($sanpObj) {
            $headers = array(
                'Content-Type: application/pdf',
            );
            return Response::download($sanpObj->snap_file_complete_path, $sanpObj->snap_file_name, $headers);
        }
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
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'cd_id' => ['required'],
            'cd_mtabs_string' => ['required'],
            'snap_file_name' => ['required'],
            'snap_file_complete_path' => ['required'],
            'is_printed' => ['required'],
        ]);

        $obj = new CdSnapHistory;
        $obj->cd_id = $request->cd_id;
        $obj->cd_mtabs_string = $request->cd_mtabs_string;
        $obj->snap_file_name = $request->snap_file_name;
        $obj->snap_file_complete_path = $request->snap_file_complete_path;
        $obj->is_printed = false;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Cd Snap History created successfully');
        return Redirect::route('cd_snap_histories.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = CdSnapHistory::find($request->id);

        $request->validate([
            'cd_id' => ['required'],
            'cd_mtabs_string' => ['required'],
            'snap_file_name' => ['required'],
            'snap_file_complete_path' => ['required'],
            'is_printed' => ['required'],
        ]);

        $obj->cd_id = $request->cd_id;
        $obj->cd_mtabs_string = $request->cd_mtabs_string;
        $obj->snap_file_name = $request->snap_file_name;
        $obj->snap_file_complete_path = $request->snap_file_complete_path;
        $obj->is_printed = $request->is_printed;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Cd Snap History updated successfully');
        return Redirect::route('cd_snap_histories.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Cd Snap History has been deleted successfully',
        ]);
    }
}
