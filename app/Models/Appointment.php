<?php

namespace App\Models;


use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\UserPreferences;
use App\Models\AppointmentStatus;
use App\Mail\AppointmentRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointment';

    protected $fillable = [
        'patient_id',
        'hospital_id',
        'doctor_id',
        'date',
        'time',
        'appointment_request_id',
        'appointment_status_id',
        'is_visitor',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function appointmentStatus()
    {
        return $this->belongsTo(AppointmentStatus::class, 'appointment_status_id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public static function getDocotorAppointments () {

        $request = request();
        $userID = auth()->user()->id;

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $search['status'] = $request->has('status') ? $request->get('status') : false;
        $search['q'] = $request->has('q') ? $request->get('q') : false;

        $data = self::leftJoin('patients as p', 'p.id', '=', 'appointment.patient_id')
        ->leftjoin('hospitals as h', 'h.id', 'appointment.hospital_id')
        ->join('doctors as d', 'd.id', '=', 'appointment.doctor_id')
        ->leftjoin('appointment_statuses as apps','apps.id','appointment.appointment_status_id')
        ->select([
            'appointment.*',
            'p.name_of_patient as patient_name',
            'h.name as hospital_name',
            'd.doctor_name as doctor_name',
            'apps.name as appointment_status',
            'p.patient_mr_number as patient_mr_number',
        ])
        ->where('appointment.hospital_id', $hospital_id)
        ->where('d.user_id', $userID);

        if ($search['q']) {
            $data = $data->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")
            ->orWhere('d.doctor_name', 'iLIKE', "%{$search['q']}%")
            ->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            $statusId = AppointmentStatus::where('name', 'iLIKE', $search['status'])->value('id');
            if ($statusId) {
                $data = $data->where('appointment.appointment_status_id', $statusId);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->latest()->paginate(10);
        return $rtn;
    }

    public static function getAllDocotorAppointments () {

        $request = request();
        $userID = auth()->user()->id;

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $search['status'] = $request->has('status') ? $request->get('status') : false;
        $search['q'] = $request->has('q') ? $request->get('q') : false;

        $data = self::leftJoin('patients as p', 'p.id', '=', 'appointment.patient_id')
        ->leftjoin('hospitals as h', 'h.id', 'appointment.hospital_id')
        ->join('doctors as d', 'd.id', '=', 'appointment.doctor_id')
        ->leftjoin('appointment_statuses as apps','apps.id','appointment.appointment_status_id')
        ->select([
            'appointment.*',
            'p.name_of_patient as patient_name',
            'h.name as hospital_name',
            'd.doctor_name as doctor_name',
            'apps.name as appointment_status',
            'p.patient_mr_number as patient_mr_number',
        ])
        ->where('appointment.hospital_id', $hospital_id)
        ->where('d.user_id', $userID);

        if ($search['q']) {
            $data = $data->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")
            ->orWhere('d.doctor_name', 'iLIKE', "%{$search['q']}%")
            ->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            $statusId = AppointmentStatus::where('name', 'iLIKE', $search['status'])->value('id');
            if ($statusId) {
                $data = $data->where('appointment.appointment_status_id', $statusId);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->latest()->paginate(10);
        return $rtn;
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;
        $search['hospital'] = $request->has('hospital') ? $request->get('hospital') : false;
        $data = self::leftJoin('patients as p', 'p.id', '=', 'appointment.patient_id')
            ->leftjoin('hospitals as h', 'h.id', 'appointment.hospital_id')
            ->leftJoin('doctors as d', 'd.id', '=', 'appointment.doctor_id')->leftjoin('appointment_statuses as apps', 'apps.id', 'appointment.appointment_status_id')
            ->select([
                'appointment.*',
                'p.name_of_patient as patient_name',
                'h.name as hospital_name',
                'd.doctor_name as doctor_name',
                'apps.name as appointment_status',
                'p.patient_mr_number as patient_mr_number',
            ]);

        if ($search['q']) {
            $data = $data->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")->orWhere('d.doctor_name', 'iLIKE', "%{$search['q']}%")->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['hospital']) {
            $data = $data->where('appointment.hospital_id', $search['hospital']);
        }

        if ($search['status'] !== false) {
            $statusId = AppointmentStatus::where('name', 'iLIKE', $search['status'])->value('id');

            if ($statusId) {
                $data = $data->where('appointment.appointment_status_id', $statusId);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->latest()->paginate(10);

        return $rtn;
    }

    public function addForm()
    {
        request()->validate([
            'doctor_id' => ['required'],
            'hospital_id' => ['required'],
            'date' => ['required'],
            'time' => ['required'],
        ], [
            'patient_id.required' => 'Patient is required',
            'doctor_id.required' => 'Doctor is required',
            'hospital_id.required' => 'Hospital is required',
        ]);

        $appointmentRequestId = request('appointment_request_id');
        $date = Carbon::createFromFormat('d/m/Y', request('date'))->format('Y-m-d');

        $appointment = Appointment::create([
            'hospital_id' => request('hospital_id'),
            'doctor_id' => request('doctor_id'),
            'patient_id' => request('patient_id'),
            'date' => Carbon::parse($date),
            'time' => request('time'),
            'appointment_request_id' => $appointmentRequestId ?? null,
            'appointment_status_id' => 1,
            'is_visitor' => 0,
            'created_by' => auth()->user()->id,
        ]);

        // If the appointment request exists, update its status to "approved"
        if ($appointmentRequestId) {
            $appointmentReq = AppointmentRequest::find($appointmentRequestId);
            if ($appointmentReq) {
                $appointmentReq->update([
                    'appointment_request_status' => 'approved',
                    'updated_by' => auth()->user()->id,
                ]);
            }
        }

        //if the patient email exists then send the email
        $patientEmail = $appointment->patient->email ?? null;
        if ($patientEmail) {
            Mail::to($patientEmail)->send(new AppointmentRegistered($appointment));
        }
        session()->flash('success', 'Appointment added successfully');
        return Redirect::route('appointments.index');

    }
    public function updateForm($id)
    {
        request()->validate([
            'doctor_id' => ['required'],
            'hospital_id' => ['required'],
            'date' => ['required', 'date_format:d/m/Y'],
            'time' => ['required'],
        ], [
            'patient_id.required' => 'Patient is required',
            'doctor_id.required' => 'Doctor is required',
            'hospital_id.required' => 'Hospital is required',
        ]);

        $date = Carbon::createFromFormat('d/m/Y', request('date'))->format('Y-m-d');

        Appointment::find($id)->update([
            'hospital_id' => request('hospital_id'),
            'doctor_id' => request('doctor_id'),
            'patient_id' => request('patient_id'),
            'date' => $date,
            'time' => request('time'),
            'appointment_request_id' => 1,
            'appointment_status_id' => request('appointment_status_id'),
            'is_visitor' => 0,
            'updated_by' => auth()->user()->id,
        ]);


        session()->flash('success', 'Appointment updated successfully');
        return Redirect::route('appointments.index');

    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Appointment has been deleted successfully',
        ]);
    }
}
