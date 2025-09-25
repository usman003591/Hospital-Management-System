<?php

namespace App\Http\Controllers\Appointment;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\AppointmentRequest;
use App\Http\Controllers\Controller;

class BookAppointmentController extends Controller
{

    public function index(Request $request){
         return view('modules.appointments.index');
    }

    public function book_appointment (Request $request) {

        $data = [];
        $hospitals = Hospital::getActiveHospitals();
        $departments = Department::getActiveDepartments();
        $doctors = Doctor::getActiveDoctors();

        return view('modules.appointments.book_appointment', compact('data','hospitals','departments','doctors'));
    }

    public function save_appointment (Request $request) {
        $obj = new AppointmentRequest();
        return $obj->addForm();
    }

}
