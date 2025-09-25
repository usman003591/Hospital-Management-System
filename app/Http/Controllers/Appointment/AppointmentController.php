<?php

namespace App\Http\Controllers\Appointment;

use App\Models\AppointmentStatus;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables; 

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

   public function fetchSpecificAppointments(Request $request)
{
    if(!checkPersonPermission('list_appointments_40')) {
               return ErrorMessage(403);
        }
    $preferences = UserPreferences::getPreferences();
    $hospital_id = $preferences['preference']['hospital_id'];
      $page = 'appointments';
    $query = Appointment::leftJoin('patients as p', 'p.id', '=', 'appointment.patient_id')
            ->leftjoin('hospitals as h', 'h.id', 'appointment.hospital_id')
            ->leftJoin('doctors as d', 'd.id', '=', 'appointment.doctor_id')->leftjoin('appointment_statuses as apps', 'apps.id', 'appointment.appointment_status_id')
            ->select([
                'appointment.*',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'h.name as hospital_name',
                'd.doctor_name as doctor_name',
                'apps.name as appointment_status',
            ])
        ->where('appointment.hospital_id', $hospital_id);

           return DataTables::of($query)
            ->addColumn('patient_name', function ($appointment) {
             return $appointment->patient_name . ' / ' . $appointment->patient_mr_number;
               })
            ->editColumn('hospital_name', function ($appointment) {
                return $appointment->hospital_name ?? '-';
            })
             ->editColumn('doctor_name', function ($appointment) {
                return $appointment->doctor_name ?? '-';
            })
            ->editColumn('date', function ($appointment) {
                return $appointment->date ?? '-';
            })
             ->editColumn('time', function ($appointment) {
                return $appointment->time ?? '-';
            })
            ->editColumn('appointment_status', function ($appointment) {
             $status = strtolower($appointment->appointment_status ?? '');

               $badges = [
              'pending' => 'badge-warning',
               'approved' => 'badge-success',
                'cancelled' => 'badge-danger',
                ];

             $class = $badges[$status] ?? 'badge-secondary'; 
             $text = ucfirst($status);
 
              return '<span class="px-4 py-2 badge ' . $class . ' font-weight-lighter">' . $text . '</span>';
            })
            ->filter(function ($query) use ($request) {
                    if ($search = $request->get('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->where('p.name_of_patient', 'ilike', "%{$search}%")
                           ->orWhere('d.doctor_name', 'ilike', "%{$search}%");
                        });
                    }
                })
           ->addColumn('action', function ($appointment) use ($page) {
            return view('modules.appointments.include.actions', compact('appointment', 'page'))->render();
            })
           ->rawColumns(['status','action','appointment_status'])
           ->make(true);
}
 
    public function index()
    {
         if(!checkPersonPermission('list_appointments_40')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.appointments.index', compact('preferences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!checkPersonPermission('create_appointments_40')) {
               return ErrorMessage(403);
        }
        $page = 'appointments';
        $module = 'Appointment';
        $patients = Patient::getForSelect();
        $doctors = Doctor::getForSelect();
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();

        return view('modules.appointments.create', compact('preferences', 'patients', 'doctors','hospitals', 'page', 'module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $obj = new Appointment();
        return $obj->addForm();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(!checkPersonPermission('update_appointments_40')) {
               return ErrorMessage(403);
        }
        $obj = Appointment::find($id);
        $page = 'appointments';
        $module = 'Appointment';
        $patients = Patient::getForSelect();
        $doctors = Doctor::getForSelect();
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();
        $appointment_statuses = AppointmentStatus::getActiveAppointmentStatuses();

        return view('modules.appointments.update', compact('preferences', 'patients', 'doctors','hospitals', 'page', 'module', 'appointment_statuses', 'obj'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $obj = new Appointment();
        return $obj->updateForm($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        if(!checkPersonPermission('delete_appointments_40')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Appointment::find($id);
            return $obj->deleteObj();
        }
    }

    public function logged_in_doctor_appointments () {

        $d = Appointment::getDocotorAppointments();
        $preferences = UserPreferences::getPreferences();
        $page = 'appointments';
        $module = 'Appointment';

        $data = $d['data'];
        $search = $d['search'];

        if (request()->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.appointments.include.list_partial', compact('data', 'page', 'search'))->render(),
            ]);
        }

        return view('modules.appointments.logged_in_doctor_appointments', compact('preferences', 'page', 'module','search','data'));

    }

    public function logged_in_doctor_appointments_daily () {

        $d = Appointment::getAllDocotorAppointments();
        $preferences = UserPreferences::getPreferences();
        $page = 'appointments';
        $module = 'Appointment';

        $data = $d['data'];
        $search = $d['search'];

        if (request()->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.appointments.include.list_partial', compact('data', 'page', 'search'))->render(),
            ]);
        }

        return view('modules.appointments.logged_in_doctor_appointments_daily', compact('preferences', 'page', 'module','search','data'));
    }
}
