<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\CdVital;
use App\Models\Patient;
use App\Models\CdDoctor;
use App\Models\Hospital;
use App\Models\LabGroup;
use App\Models\Department;
use App\Models\LabInvoice;
use App\Models\CdComplaint;
use App\Models\LabGroupTest;
use Illuminate\Http\Request;
use App\Models\CdBriefHistory;
use App\Models\LabInvoiceItem;
use App\Models\UserPreferences;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CdInvestigations;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\File;
use App\Models\LabInvestigationPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use App\Models\CdGeneralPhysicalExamination;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CdSystematicPhysicalExamination;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClinicalDiagnosis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clinical_diagnoses';

    protected $fillable = ['patient_id', 'created_by', 'updated_by', 'deleted_by', 'status', 'hospital_id', 'count', 'date', 'token_number', 'counter_id'];

    //Relationships
    public function cdComplaints()
    {
        return $this->hasMany(CdComplaint::class, 'cd_id');
    }

    public function cdDoctors()
    {
        return $this->hasMany(CdDoctor::class, 'cd_id');
    }

    public function cdVitals()
    {
        return $this->hasMany(CdVital::class, 'cd_id');
    }

    public function cdBriefHistories()
    {
        return $this->hasMany(CdBriefHistory::class, 'cd_id');
    }

    public function cdGeneralPhysicalExaminations()
    {
        return $this->hasMany(CdGeneralPhysicalExamination::class, 'cd_id');
    }

    public function cdSystematicPhysicalExaminations()
    {
        return $this->hasMany(CdSystematicPhysicalExamination::class, 'cd_id');
    }

    public static function getActiveStatus()
    {
        return self::where('status', 1)->get();
    }

    public static function getMyPatientListingRecord()
    {
        $request = request();
        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $today = Carbon::now()->format('Y-m-d') . '%';

        $doctor_id = getDoctorId();
        $data = self::leftjoin('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->leftjoin('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->leftjoin('doctors as d', 'cdd.doctor_id', 'd.id')
            ->leftjoin('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
            ->select([
                'clinical_diagnoses.*',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date as start_date',
                'cdd.end_date as end_date',
                'd.doctor_name as doctor_name',
                'h.name as hospital_name',
                'h.hospital_abbreviation as hospital_abbreviation',
            ])->whereDate('clinical_diagnoses.created_at', $today)
            ->where('d.id', $doctor_id);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")
                      ->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%")
                      ->orWhere('p.cell', 'iLIKE', "%{$search['q']}%");
            });
        }

         if ($search['status'] === false) {
            $data = $data->where('clinical_diagnoses.status','=','pending');
         } else if ($search['status']) {
            $data = $data->where('clinical_diagnoses.status', $search['status']);
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('clinical_diagnoses.created_at', 'asc')->paginate(10);

        return $rtn;

    }

    public static function getMyAllRecord()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $doctor_id = getDoctorId();
        $data = self::leftjoin('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->leftjoin('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->leftjoin('doctors as d', 'cdd.doctor_id', 'd.id')
            ->leftjoin('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
            ->leftjoin('o_p_d_counters as counter', 'counter.id', operator: 'clinical_diagnoses.counter_id')
            ->select([
                'clinical_diagnoses.*',
                'counter.name as counter_name',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date as start_date',
                'cdd.end_date as end_date',
                'd.doctor_name as doctor_name',
                'h.name as hospital_name',
                'h.hospital_abbreviation as hospital_abbreviation',
            ])
            ->where('d.id', $doctor_id);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('p.cell', 'iLIKE', "%{$search['q']}%");
            });
        }

        if ($search['status']) {
            $data = $data->where('clinical_diagnoses.status', $search['status']);
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'desc')
            ->paginate(10);

        return $rtn;
    }

    public static function getDoctorStats() {

            $today = Carbon::now()->format('Y-m-d') . '%';
            $doctor_id = getDoctorId();

            $data = self::leftjoin('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->leftjoin('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->leftjoin('doctors as d', 'cdd.doctor_id', 'd.id')
            ->leftjoin('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
            ->leftjoin('o_p_d_counters as counter', 'counter.id', operator: 'clinical_diagnoses.counter_id')
            ->select([
                'clinical_diagnoses.*',
                'counter.name as counter_name',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date as start_date',
                'cdd.end_date as end_date',
                'd.doctor_name as doctor_name',
                'h.name as hospital_name',
                'h.hospital_abbreviation as hospital_abbreviation',
            ])
            ->whereDate('clinical_diagnoses.created_at', $today)
            ->where('d.id', $doctor_id)
            ->get();

            $all_patients_count = count($data);
            $pending_patient_count = 0;
            $referred_patient_count = 0;

            foreach ($data as $d) {

                if($d->status == 'pending') {
                   $pending_patient_count++;
                } elseif ($d->status == 'referred') {
                   $referred_patient_count++;  }

            }

            $rtn['all_patients_count'] = $all_patients_count;
            $rtn['pending_patient_count'] = $pending_patient_count;
            $rtn['referred_patient_count'] = $referred_patient_count;

            return $rtn;
    }

    public static function getMyDailyRecord()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;
        // $search['doctor_id'] = $request->has('doctor_id') ? $request->get('doctor_id') : false;
        // $search['hospital'] = $request->has('hospital') ? $request->get('hospital') : false;
        $today = Carbon::now()->format('Y-m-d') . '%';

        $doctor_id = getDoctorId();
        $data = self::leftjoin('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->leftjoin('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->leftjoin('doctors as d', 'cdd.doctor_id', 'd.id')
            ->leftjoin('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
            ->leftjoin('o_p_d_counters as counter', 'counter.id', operator: 'clinical_diagnoses.counter_id')
            ->select([
                'clinical_diagnoses.*',
                'counter.name as counter_name',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date as start_date',
                'cdd.end_date as end_date',
                'd.doctor_name as doctor_name',
                'h.name as hospital_name',
                'h.hospital_abbreviation as hospital_abbreviation',
            ])->whereDate('clinical_diagnoses.created_at', $today)
            ->where('d.id', $doctor_id);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('p.cell', 'iLIKE', "%{$search['q']}%");
            });
        }

        if ($search['status']) {
            $data = $data->where('clinical_diagnoses.status', $search['status']);
        } else {
            $data = $data->where('clinical_diagnoses.status','pending');
        }

        // if ($search['hospital']) {
        //     $data = $data->where('clinical_diagnoses.hospital_id', $search['hospital']);
        // }

        // if ($search['doctor_id']) {
        //     $data = $data->where('d.id', $search['doctor_id']);
        // } else {
        //     $data = $data;
        // }


        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'asc')
            ->paginate(10);

        return $rtn;
    }


    public static function getPatientClinicalDiagnosisHistory ($patient_id) {

       $preferences = UserPreferences::getPreferences();
       $hospital_id = $preferences['preference']['hospital_id'];

       $data = self::join('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->join('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->join('doctors as d', 'cdd.doctor_id', 'd.id')
            ->join('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
            ->join('o_p_d_counters as counter', 'counter.id', operator: 'clinical_diagnoses.counter_id')
            ->select([
                'clinical_diagnoses.*',
                'counter.name as counter_name',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date as start_date',
                'cdd.end_date as end_date',
                'd.id as doctor',
                'd.doctor_name as doctor_name',
                'd.user_id as user',
                'h.name as hospital_name',
                'h.hospital_abbreviation as h_abbreviation',
            ])
            ->where('clinical_diagnoses.status', 'completed')
            ->where('p.id',$patient_id)
            ->where('h.id',$hospital_id)
            ->latest()
            ->limit(15)
            ->get();

            return $data;
    }

    //Static Methods
    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;
        $search['hospital'] = $request->has('hospital') ? $request->get('hospital') : false;

        $data = self::leftjoin('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->leftjoin('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->leftjoin('doctors as d', 'cdd.doctor_id', 'd.id')
            ->leftjoin('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
            ->leftjoin('o_p_d_counters as counter', 'counter.id', 'clinical_diagnoses.counter_id')
            ->select([
                'clinical_diagnoses.*',
                'counter.name as counter_name',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date as start_date',
                'cdd.end_date as end_date',
                'd.doctor_name as doctor_name',
                'h.name as hospital_name',
            ]);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) { //$query is the query builder instance and $search is the array of search parameters

                $query->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")
                      ->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%")
                      ->orWhere('p.cell', 'iLIKE', "%{$search['q']}%");
            });
        }

        if ($search['hospital']) {
            $data = $data->where('clinical_diagnoses.hospital_id', $search['hospital']);
        }

        // Add status filter
        if ($search['status']) {
            $data = $data->where('clinical_diagnoses.status', $search['status']);
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('clinical_diagnoses.created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public static function getDistinctStatuses()
    {
        return self::select('status')
            ->distinct()
            ->whereNotNull('status')
            ->pluck('status')
            ->toArray();
    }

    public static function getDailyRecord()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;
        $search['doctor_id'] = $request->has('doctor_id') ? $request->get('doctor_id') : false;
        $search['hospital'] = $request->has('hospital') ? $request->get('hospital') : false;

        $today = Carbon::now()->format('Y-m-d') . '%';

        $data = self::leftjoin('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->leftjoin('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->leftjoin('doctors as d', 'cdd.doctor_id', 'd.id')
            ->leftjoin('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
            ->leftjoin('o_p_d_counters as counter', 'counter.id', 'clinical_diagnoses.counter_id')
            ->select([
                'clinical_diagnoses.*',
                'p.name_of_patient as patient_name',
                'counter.name as counter_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date as start_date',
                'cdd.end_date as end_date',
                'd.doctor_name as doctor_name',
                'h.name as hospital_name',
                'h.hospital_abbreviation as hospital_abbreviation',
            ])->whereDate('clinical_diagnoses.created_at', $today);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%");
            });
        }

        if ($search['status'] != 2) {
            $data = $data->where('clinical_diagnoses.status', $search['status']);
        } elseif ($search['status'] == 2) {
            $data = $data;
        } else {
            $data = $data->where('clinical_diagnoses.status', 'Pending');
        }

        if ($search['hospital']) {
            $data = $data->where('clinical_diagnoses.hospital_id', $search['hospital']);
        }

        if ($search['doctor_id']) {
            $data = $data->where('d.id', $search['doctor_id']);
        } else {
            $data = $data;
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'desc')
            ->where('clinical_diagnoses.created_at', 'like', $today)
            ->paginate(10);

        return $rtn;
    }

    public static function getPatientClinicalDiagnosis($patient_id)
    {

        $data = self::leftjoin('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->leftjoin('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->leftjoin('doctors as d', 'cdd.doctor_id', 'd.id')
            ->leftjoin('o_p_d_counters as counter', 'counter.id', 'clinical_diagnoses.counter_id')
            ->select([
                'clinical_diagnoses.*',
                'counter.name as counter_name',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date as start_date',
                'cdd.end_date as end_date',
                'd.doctor_name as doctor_name',
            ])
            ->where('p.id', $patient_id)
            ->orderby('created_at', 'desc')->paginate(10);

        return $data;

    }

    public function addForm()
    {
        request()->validate([
            'patient_id' => ['required', 'integer'],
            'counter_id' => ['required', 'integer'],
            'doctor_id' => ['nullable', 'integer'],
            'hospital_id' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ], [
            'counter_id.required' => 'Counter is required',
            'patient_id.required' => 'Patient is required',
            'start_date.required' => 'Start date is required',
            'end_date.required' => 'End date is required',
        ]);

        $today = Carbon::today()->toDateString();
        // Get the last counter number for today
        $lastCounter = ClinicalDiagnosis::where('date', $today)
            ->where('hospital_id', request('hospital_id'))
            ->where('counter_id', request('counter_id'))
            ->orderBy('count', 'desc')
            ->first();


        // Calculate the next counter number
        $nextCounterNumber = $lastCounter ? $lastCounter->count + 1 : 1;

        $clinical_diagnosis = ClinicalDiagnosis::create([
            'patient_id' => request('patient_id'),
            'created_by' => auth()->user()->id,
            'hospital_id' => request('hospital_id'),
            'counter_id' => request('counter_id'),
            'count' => $nextCounterNumber,
            'token_number' => $nextCounterNumber,
            'date' => $today
        ]);

        if(request('doctor_id')) {
            $now = Carbon::now();
            $cd_doctors = CdDoctor::create([
                'cd_id' => $clinical_diagnosis->id,
                'doctor_id' => request('doctor_id'),
                'start_date' => Carbon::parse($now),
                'end_date' => Carbon::parse(request('end_date')),
                'created_by' => auth()->user()->id
            ]);


            $notification_template = Notification::where('notification_slug', 'opd-for-doctors-patient-registration')->first();
            if ($notification_template) {

                $patient = Patient::find($clinical_diagnosis->patient_id);
                $doctor = Doctor::find($cd_doctors->doctor_id);

                $data = [
                    'patient_name' => $patient->name_of_patient,
                    'mr_number' => $patient->patient_mr_number,
                    'doctor_name' => $doctor->doctor_name,
                ];

                $messageTemplate  = $notification_template->description;

                foreach ($data as $key => $value) {
                    $messageTemplate = str_replace("[$key]", $value, $messageTemplate);
                }

                NotificationUser::sendNotification($doctor->user_id, $notification_template, $messageTemplate);
            }
        }


        session()->flash('success', 'OPD record added successfully');
        return Redirect::route('clinical_diagnosis.download', $clinical_diagnosis->id);
    }

    public function updateForm()
    {
        $cd = request()->validate([
            // 'cd_id' => ['required', 'integer'],
            'patient_id' => ['required', 'string'],
            'hospital_id' => ['required'],
            // 'start_date' => ['required', 'date'],
            // 'end_date' => ['required', 'date'],
        ], [
            // 'cd_id.required' => 'System failure Please Contact IT support',
            'patient_id.required' => 'Patient is required',
            // 'start_date.required' => 'Start date is required',
            // 'end_date.required' => 'End date is required',
        ]);

        // Update ClinicalDiagnosis
        $clinical_diagnosis = ClinicalDiagnosis::find(request('cd_id'));
        if ($clinical_diagnosis) {
            $clinical_diagnosis->patient_id = request('patient_id');
            $clinical_diagnosis->hospital_id = request('hospital_id');
            $clinical_diagnosis->updated_by = auth()->user()->id;
            $clinical_diagnosis->update();
        }

        // Update CdDoctor
        $cd_doctor = CdDoctor::where('cd_id', request('cd_id'))->first();
        if ($cd_doctor) {
            $cd_doctor->doctor_id = request('doctor_id'); // Assign selected doctor
            $cd_doctor->start_date = Carbon::parse(request('start_date'));
            $cd_doctor->end_date = Carbon::parse(request('end_date'));
            $cd_doctor->updated_by = auth()->user()->id;
            $cd_doctor->save();
        } else {

            $doctor_id = request('doctor_id'); // Assign selected doctor
            $cd_id = request('cd_id');
            $cd_doctor = new CdDoctor;
            $cd_doctor->cd_id = $cd_id;
            $cd_doctor->doctor_id = $doctor_id; // Assign selected doctor
            $cd_doctor->start_date = Carbon::parse(now());
            $cd_doctor->end_date = Carbon::parse(now());
            $cd_doctor->updated_by = auth()->user()->id;
            $cd_doctor->save();

        }

        session()->flash('success', 'Clinical diagnosis updated successfully');
        return Redirect::route('clinical_diagnosis.index', ['id' => $clinical_diagnosis->id]);
    }

    public static function changeStatus($id, $status)
    {
        $adv = self::where('id', $id)->first();
        if ($adv) {
            $adv->status = $status;
            $adv->update();
            return "status updated successfully";
        } else
            return "No record found";
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Clinical diagnosis has been deleted successfully',
        ]);
    }

    public function generateInvestigationsRecord($investigations, $discount_percentage)
    {
        try {


        $doctorObj = CdDoctor::where('cd_id', $this->id)->first();
        $patient_id = $this->patient_id;

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $labGroupObj = new LabGroup;
        $labGroupObj->patient_id = $patient_id;
        $labGroupObj->doctor_id = $doctorObj->doctor_id;
        $labGroupObj->hospital_id = $hospital_id;
        $labGroupObj->clinical_diagnosis_id = $this->id;
        $labGroupObj->lab_group_number = now()->format('YmdHis');
        $labGroupObj->created_by = auth()->user()->id;
        $labGroupObj->save();

        if($investigations) {
        $date = date('Y-m-d');
            foreach ($investigations as $investigation) {
                if(isset($investigation['perform_investigation'][0])) {

                            $matchThese = ['lab_group_id' => $labGroupObj->id, 'investigation_id' => intVal($investigation['pathology'])];
                            LabGroupTest::updateOrCreate($matchThese, [
                            'dated' => $date,
                            'report_date' => $date,
                            'status' => 'pending',
                            'created_by' => auth()->user()->id,
                        ]);

                    }
                }
        }

        $now = Carbon::now();
        $LabInvoiceObj = LabInvoice::updateOrCreate(
            ['id' => $labGroupObj->lab_invoice_id],
            [
                'patient_id'          => $labGroupObj->patient_id,
                'lab_group_id'        => $labGroupObj->id,
                'total_amount'        => 0,
                'hospital_id'         => $hospital_id,
                'discount_amount'     => 0,
                'discount_percentage' => $discount_percentage,
                'date_issued'        => Carbon::parse($now),
                'net_amount'          => 0,
                'amount_received'     => 0,
                'created_by'          => auth()->id(),
            ]
        );

        $labGroupObj->lab_invoice_id = $LabInvoiceObj->id;
        $labGroupObj->update();

        $price = 0;
        $total_amount = 0;
        $total_investigation_items = 0;
        $filldata_services = 0;
        $discount_amount = 0;
        $patient = null;

        foreach ($investigations as $investigation) {
                $patient = Patient::find($labGroupObj->patient_id);

                if(isset($investigation['perform_investigation'][0])) {

                    if ($patient->patient_category) {
                    $priceObj = LabInvestigationPrice::getInvestigationPrice(intVal($investigation['pathology']));
                    $price = (integer) $priceObj->price;

                        if (LabInvoiceItem::where('lab_invoice_id', '=', $LabInvoiceObj->id)->where('investigation_id', intVal($investigation['pathology']))->withTrashed()->exists()) {
                            LabInvoiceItem::where('lab_invoice_id', $LabInvoiceObj->id)->where('investigation_id', intVal($investigation['pathology']))->withTrashed()->restore();
                            $newObj = LabInvoiceItem::where('lab_invoice_id', $LabInvoiceObj->id)->where('investigation_id', intVal($investigation['pathology']))->first();
                            $newObj->updated_by = auth()->user()->id;
                            $newObj->save();
                        } else {
                            $matchThese = ['lab_invoice_id' => $LabInvoiceObj->id, 'investigation_id' => intVal($investigation['pathology'])];
                            $lab_invoice_item = LabInvoiceItem::updateOrCreate($matchThese, ['price' => $price, 'investigation_price_id' => $priceObj->id, 'created_by' => auth()->user()->id]);
                        }

                        $total_amount = $total_amount + $price;
                        $total_investigation_items++;
                    }
                }
          }


        $LabInvoiceObj->total_amount = $total_amount;
        $discount_amount = ($LabInvoiceObj->discount_percentage/100)*$total_amount;
        $LabInvoiceObj->net_amount = $total_amount - $discount_amount;
        $LabInvoiceObj->amount_received = $LabInvoiceObj->net_amount;
        $LabInvoiceObj->discount_amount = $discount_amount;
        $LabInvoiceObj->invoice_sequence = generateLabSequenceInvoice($LabInvoiceObj->receipt_number);
        $LabInvoiceObj->update();

        if ($total_investigation_items < 6) {
            $filldata_investigations = 6 - $total_investigation_items;
        }


        session()->flash('success', 'OPD investigations updated successfully');
        return Redirect::route('lab_groups.index');

        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error while saving data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.' . $e->getMessage());
        }

    }

    public function generateLabReceipt($labGroupObj, $clinicalDiagnosisId, $patient_id, $doctor_id, $hospital_id)
    {
        // Logic to generate lab receipt
            if ($patient_id && $doctor_id) {

            $clinical_diagnosis_data = ClinicalDiagnosis::join('o_p_d_counters as counter', 'counter.id', 'clinical_diagnoses.counter_id')
            ->select([
                'counter.name as counter_name',
                'clinical_diagnoses.*'
            ])
            ->where('clinical_diagnoses.id', $clinicalDiagnosisId)->first();

            $lab_group_tests = LabGroupTest::getLabGroupTests($labGroupObj->id);
            $patient_data = Patient::withTrashed()->find($patient_id);
            $doctor_data = Doctor::withTrashed()->find($doctor_id);
            $department_data = Department::find($doctor_data->department_id);
            $hospital = Hospital::find($hospital_id);
            $customPaper = array(0, 0, 567.00, 283.80);

            $button_url = config('app.url') . '/lab_groups/5/lab_tests';
            $qrCode = \QrCode::size(60)->generate($button_url);

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.lab_receipts.investigation_slip', compact('patient_data', 'doctor_data', 'department_data', 'hospital', 'clinical_diagnosis_data', 'lab_group_tests','qrCode'))
                ->setPaper($customPaper, 'portrait');
            // ->setPaper('A6');

            $dir = self::getLabReceiptsDir();
            $extension = 'pdf';
            $FileName = strtolower(time() . '_' . rand(1000, 9999) . '.' . $extension);
            $path = public_path() . '/' . $dir;
            File::isDirectory(directory: $path) or File::makeDirectory($path, 0777, true, true);
            $pdf->save($path . $FileName);
            $file = $path . $FileName;
            $labGroupObj->receipt_name = $FileName;
            $labGroupObj->receipt_file_path = url($dir . $FileName);
            $labGroupObj->update();

            return $pdf->stream('investigations_slip_download.pdf');

        }

    }

    public static function getLabReceiptsDir () {
          return 'assets/lab_receipts/';
    }

    public function generateFromHtmlPlainOpdSlip($id)
    {
        // $clinical_diagnosis_data = ClinicalDiagnosis::find($id);
        $clinical_diagnosis_data = ClinicalDiagnosis::join('o_p_d_counters as counter', 'counter.id', 'clinical_diagnoses.counter_id')
            ->select([
                'counter.name as counter_name',
                'clinical_diagnoses.*'
            ])
            ->where('clinical_diagnoses.id', $id)->first();
        if ($clinical_diagnosis_data) {

            $patient_id = $clinical_diagnosis_data->patient_id;
            $cd_doctor_diagnosis_data = CdDoctor::where('cd_id', $clinical_diagnosis_data->id)->withTrashed()->first();

            if (!is_null($cd_doctor_diagnosis_data)) {
               $doctor_id = $cd_doctor_diagnosis_data->doctor_id;
            } else {
               $doctor_id = null;
            }

            if ($patient_id) {

                $patient_data = Patient::withTrashed()->find($patient_id);

                if($doctor_id) {
                   $doctor_data = Doctor::withTrashed()->find($doctor_id);
                } else {
                   $doctor_data = null;
                }

                if ($doctor_data) {
                  $department_data = Department::find($doctor_data->department_id);
                } else {
                  $department_data = null;
                }

                $hospital = Hospital::find($clinical_diagnosis_data->hospital_id);
                $button_url = route('clinical_diagnosis.detail_form', ['id' => $id]);

                // $customPaper = array(0,0,720,1440);
                $customPaper = array(0, 0, 567.00, 283.80);
                //generating QR code
                $qrCode = \QrCode::size(300)->generate($button_url); // Replace with your URL or data

                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                    ->loadView('documents.opd_receipts.opd_receipt', compact('patient_data', 'doctor_data', 'department_data', 'hospital', 'clinical_diagnosis_data', 'qrCode'))
                    ->setPaper($customPaper, 'portrait');
                // ->setPaper('A6');

                return $pdf->stream('opd_slip_download.pdf');
            }
        }
    }

    public static function getPreviewData($id)
    {
        $obj = ClinicalDiagnosis::find($id);

        $preferences = UserPreferences::getPreferences();

        $patient = Patient::find($obj->patient_id);
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found');
        }

        $cdBriefHistoryData = CdBriefHistory::where('cd_id', $obj->id)->first();

        $cdDiagnosisData = CdDiagnosis::getDiagnosisData($obj->id);

        $cdProcedureData = CdProcedure::getProcedureData($obj->id);

        $cdComplaintData = CdComplaint::getComplaintsData($obj->id);

        $cdGPEData = CdGeneralPhysicalExamination::getGPEData($obj->id);

        $cdSPEData = CdSystematicPhysicalExamination::getSPEData($obj->id);

        $radiologyData = CdInvestigations::getInvestigationsData($obj->id, 1);
        $pathologyData = CdInvestigations::getInvestigationsData($obj->id, 2);
        $rehablitationData = CdInvestigations::getInvestigationsData($obj->id, 3);

        $CdVital = CdVital::where('cd_id', $obj->id)->get();
        $vitals = Vital::getActiveVitals();

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

        $medicationData = CdTreatment::getTreatmentData($obj->id);


        return view(
            'modules.clinical_diagnosis.detail.preview_opd_records',

            compact(
                'patient',
                'obj',
                'preferences',
                'cdBriefHistoryData',
                'cdDiagnosisData',
                'cdProcedureData',
                'cdComplaintData',
                'cdGPEData',
                'cdSPEData',
                'radiologyData',
                'pathologyData',
                'rehablitationData',
                'vitals',
                'updatedVitalData',
                'medicationData',
            )
        );
    }


}
