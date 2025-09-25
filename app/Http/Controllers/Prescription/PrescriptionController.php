<?php

namespace App\Http\Controllers\Prescription;

use FPDF;
use App\Models\Doctor;
use App\Models\Patient;
use setasign\Fpdi\Fpdi;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\OPDCounter;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;


class PrescriptionController extends Controller
{
public function fetchSpecificPrescriptions(Request $request)
{
    $preferences = UserPreferences::getPreferences();
    $hospital_id = $preferences['preference']['hospital_id'];
    $page = 'prescriptions';

    if ($request->ajax()) {
        $query = Prescription::leftJoin('patients as p', 'p.id', '=', 'prescriptions.patient_id')
            ->leftJoin('hospitals as h', 'h.id', '=', 'prescriptions.hospital_id')
            ->leftJoin('doctors as d', 'd.id', '=', 'prescriptions.doctor_id')
            ->leftjoin('o_p_d_counters as counter','counter.id', 'prescriptions.counter_id')
            ->select([
                'prescriptions.id',
                'prescriptions.status',
                'counter.name as counter_name',
                'prescriptions.token_number',
                'prescriptions.created_at',
                'p.name_of_patient as patient_name',
                'd.doctor_name',
                'h.name as hospital_name',
            ])
            ->where('prescriptions.hospital_id', $hospital_id)->orderBy('prescriptions.created_at', 'desc');

        return DataTables::of($query)
            ->editColumn('patient_name', function ($prescription) {
                return $prescription->patient_name ?? '-';
            })
            ->editColumn('doctor_name', function ($prescription) {
                return $prescription->doctor_name ?? '-';
            })
            ->editColumn('hospital_name', function ($prescription) {
                return $prescription->hospital_name ?? '-';
            })
             ->addColumn('counter_token', function ($row) {
             return $row->counter_name . ' / ' . $row->token_number;
               })
            ->editColumn('created_at', function ($prescription) {
             return optional($prescription->created_at)->format('d-m-Y H:i') ?? '-';
            })
            ->editColumn('status', function ($prescription) {
                $status = $prescription->status ?? '-';
                $class = $status == 'paid' ? 'badge bg-success' : 'badge bg-warning';
                return '<span class="'.$class.'">'.ucfirst($status).'</span>';
            })
            ->filter(function ($query) use ($request) {
                if ($search = $request->get('search')['value']) {
                    $query->where(function ($q) use ($search) {
                        $q->where('p.name_of_patient', 'ilike', "%{$search}%")
                          ->orWhere('d.doctor_name', 'ilike', "%{$search}%")
                          ->orWhere('prescriptions.token_number', 'ilike', "%{$search}%")
                          ->orWhere('counter.name', 'ilike', "%{$search}%");
                    });
                }
            })
            ->addColumn('action', function ($prescription) use ($page) {
                return view('modules.prescriptions.include.actions', compact('prescription', 'page'))->render();
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_prescriptions_section_7')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.prescriptions.index', compact('preferences'));
    }

    public function create(Request $request)
    {
          if(!checkPersonPermission('create_prescriptions_section_7')) {
               return ErrorMessage(403);
        }
        $counters = OPDCounter::getActiveCounters();
        $patients = Patient::getForSelect();
        $doctors = Doctor::getUsersLoggedInHospitalDoctors();
        // $doctors = Doctor::getForSelect();
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();

        return view('modules.prescriptions.create', compact('preferences', 'patients', 'doctors','hospitals','counters'));
    }

    public function edit($id)
    {
  if(!checkPersonPermission('update_prescriptions_section_7')) {
               return ErrorMessage(403);
        }
        $obj = Prescription::find($id);
        $hospitals = Hospital::getActiveHospitals();
        $patients = Patient::getForSelect();
        $doctors = Doctor::getUsersLoggedInHospitalDoctors();
        // $doctors = Doctor::getForSelect();
        $preferences = UserPreferences::getPreferences();

        return view('modules.prescriptions.update', compact('preferences', 'obj', 'patients', 'doctors','hospitals'));

    }

    public function store(Request $request)
    {

        $obj = new Prescription();
        return $obj->addForm();
    }

    public function update(Request $request)
    {

        $obj = new Prescription();
        return $obj->updateForm();
    }

    public function delete($id = false)
    {
          if(!checkPersonPermission('delete_prescriptions_section_7')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Prescription::find($id);
            return $obj->deleteObj();
        }
    }

    public function download_prescription($id)
    {
          if(!checkPersonPermission('download_prescription_slip_prescriptions_section_7')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = new Prescription();
            return $obj->generateFromHtmlPlainPrescription($id);
        }
    }

}
