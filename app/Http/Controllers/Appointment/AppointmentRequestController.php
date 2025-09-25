<?php

namespace App\Http\Controllers\Appointment;


use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\AppointmentRequest;
use App\Http\Controllers\Controller;

class AppointmentRequestController extends Controller
{
    public function index(Request $request)
    {
  if(!checkPersonPermission('list_appointment_requests_39')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.appointments.appointment_requests.index', compact('preferences'));

    }

    public function show($id)
    {
         if(!checkPersonPermission('detail_appointment_requests_39')) {
               return ErrorMessage(403);
        }
        $appointmentReq = AppointmentRequest::getDetail($id);
        if (!$appointmentReq) {
            return redirect()->route('appointment_requests.index')->with('error', 'Appointment request not found.');
        }

        $preferences = UserPreferences::getPreferences();
        $hospitals = Hospital::getActiveHospitals();
        $doctors = Doctor::getForSelect();
        $patients = Patient::getForSelect();
        $page = 'appointment_requests';

        $appointmentRequest = AppointmentRequest::find($id);

        if (!$appointmentRequest) {
            abort(404, 'Appointment Request not found');
        }


        return view('modules.appointments.appointment_requests.show', compact('preferences', 'appointmentReq', 'hospitals', 'doctors', 'patients', 'page', 'appointmentRequest'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_appointment_requests_39')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = AppointmentRequest::find($id);
            return $obj->deleteObj();
        }
    }
}
