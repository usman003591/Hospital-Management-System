<?php

namespace App\Models;

use App\Mail\VisitorAppointmentRequest;
use Carbon\Carbon;
use App\Models\Patient;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use App\Mail\AppointmentRequestRegistered;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointment_requests';

    protected $fillable = [
        'hospital_id', //
        'doctor_id', //
        'patient_id',
        'patient_name', //
        'patient_email', //
        'patient_number', //
        'patient_cnic_number', //
        'appointment_request_status', //
        'request_date', //
        'preferred_date',
        'preferred_time',
        'is_visitor',
        'parent_id',
        'created_by',
        'updated_by'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'hospital_id' => ['required'],
            'doctor_id' => ['required'],
            'patient_name' => ['required'],
            'patient_email' => ['required'],
            'patient_number' => ['required', 'digits_between:10,11'],
            'patient_cnic_number' => [
                'required',
                'size:15',
                // Rule::unique(AppointmentRequest::class, 'patient_cnic_number')->whereNull('deleted_at')
            ],
            'preferred_date' => ['required'],
            'preferred_time' => ['required'],
            'department_id' => ['required'],
        ], [
            'hospital_id.required' => 'Please Select Hospital',
            'department_id.required' => 'Please Select Department',
            'doctor_id.required' => 'Please Select Doctor',
            'patient_name.required' => 'Please Enter Name',
            'patient_email.required' => 'Please Enter Email',
            'patient_number.required' => 'Please Enter Your Cellphone Number',
            'patient_cnic_number.required' => 'Please Enter Your CNIC Number',
            'preferred_date.required' => 'Please select your preferred date',
            'preferred_time.required' => 'Please select your preferred time',
            'patient_cnic_number.unique' => 'This CNIC number is already registered in the system',
        ]);

        $isVisitor = Patient::where('cnic_number', $request->patient_cnic_number)->exists() ? 0 : 1;

        $obj = new AppointmentRequest;
        $obj->hospital_id = $request->hospital_id;
        $obj->doctor_id = $request->doctor_id;
        $obj->patient_name = $request->patient_name;
        $obj->patient_email = $request->patient_email;
        $obj->patient_number = $request->patient_number;
        $obj->patient_cnic_number = $request->patient_cnic_number;
        $obj->request_date = Carbon::parse($request->preferred_date);
        $obj->preferred_date = Carbon::parse($request->preferred_date);
        $obj->preferred_time = Carbon::parse($request->preferred_time);
        $obj->created_by = 1;
        $obj->is_visitor = $isVisitor;
        $obj->save();


        if($isVisitor == 0){

            $patient = Patient::where('cnic_number', $obj->patient_cnic_number)->select('email')->get();
            $obj->patient_id = $patient[0]->id;
            $obj->update();

            Mail::to($patient)->send(
                new AppointmentRequestRegistered($obj)
            );

        }
        else {
            Mail::to($obj->patient_email)->send(
                new VisitorAppointmentRequest($obj)
            );
        }


        session()->flash('success', 'Book appointment request received successfully');
        return Redirect::route('patients.book_appointment');
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['hospital'] = $request->has('hospital') ? $request->get('hospital') : false;
        $search['doctor'] = $request->has('doctor') ? $request->get('doctor') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::leftJoin('hospitals as h', 'h.id', '=', 'appointment_requests.hospital_id')
        ->leftJoin('doctors as d', 'd.id', '=', 'appointment_requests.doctor_id')
        ->leftJoin('patients as p', 'p.cnic_number', '=', 'appointment_requests.patient_cnic_number')
        ->select([
            'appointment_requests.*',
            'h.name as hospital_name',
            'p.name_of_patient as patientName',
            'd.doctor_name as doctor_name',
        ]);


        if ($search['q']) {
            $data = $data->where('appointment_requests.patient_name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['hospital']) {
            $data = $data->where('appointment_requests.hospital_id', $search['hospital']);
        }

        if ($search['doctor']) {
            $data = $data->where('appointment_requests.doctor_id', $search['doctor']);
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 'pending') {
                $data = $data->where('appointment_requests.appointment_request_status', 'pending');
            } elseif ($search['status'] == 'approved') {
                $data = $data->where('appointment_requests.appointment_request_status', 'approved');
            } elseif ($search['status'] == 'cancelled') {
                $data = $data->where('appointment_requests.appointment_request_status', 'cancelled');
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->latest()->paginate(10);

        return $rtn;
    }

    public static function getDetail($id)
    {
        $data = self::leftjoin('hospitals as h', 'h.id', '=', 'appointment_requests.hospital_id')
            ->leftJoin('doctors as d', 'd.id', '=', 'appointment_requests.doctor_id')->leftJoin('patients as pt', 'pt.id', '=', 'appointment_requests.patient_id')
            ->leftJoin('patients as p', 'p.cnic_number', '=', 'appointment_requests.patient_cnic_number')
            ->select([
                'appointment_requests.*',
                'h.name as hospital_name',
                'd.doctor_name as doctor_name',
                'p.*',
            ])->where('appointment_requests.id', $id)->first();
            if (!$data) {
                abort(404, 'Appointment Request not found');
            }
            return $data;
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
