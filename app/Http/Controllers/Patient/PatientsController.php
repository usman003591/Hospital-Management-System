<?php

namespace App\Http\Controllers\Patient;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\ClinicalDiagnosis;
use App\Http\Controllers\Controller;
use DB;

class PatientsController extends Controller
{
    public function checkCnic(Request $request)
    {
            $inputCnic = $request->cnic;
            $cnicNoDashes = str_replace('-', '', $inputCnic);
            $cnicWithDashes = $inputCnic;

            $patient = Patient::where('cnic_number', $cnicWithDashes)
                ->orWhere('cnic_number', $cnicNoDashes)
                ->select('id', 'name_of_patient', 'cell', 'gender', 'age', 'patient_category','year_of_birth', 'date_of_birth')
                ->first();

            if ($patient) {
                $response = response()->json([
                    'status' => 'found',
                    'data' => [
                        'id' => $patient->id,
                        'name' => $patient->name_of_patient,
                        'cell_number' => $patient->cell ?? '',
                        'gender' => $patient->gender ?? '',
                        'age' => intval($patient->age) ?? '',
                        'patient_category' => $patient->patient_category ?? '',
                        'year_of_birth' => $patient->year_of_birth ?? '',
                        'date_of_birth' => $patient->date_of_birth ?? '',
                    ]
                ]);

                return $response;
            }

            return response()->json(['status' => 'not_found']);
    }

    public function create(Request $request)
    {
        if(!checkPersonPermission('create_patients_section_6')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.patients.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new Patient();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {

        $obj = new Patient();
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {

        if(!checkPersonPermission('list_patients_section_6')) {
               return ErrorMessage(403);
        }


        $preferences = UserPreferences::getPreferences();
        return view('modules.patients.index', compact('preferences'));
    }

    public function show($id)
    {
        if(!checkPersonPermission('detail_patients_section_6')) {
               return ErrorMessage(403);
        }


        $patient = Patient::with('emergencyContact')->find($id);

        $data = ClinicalDiagnosis::getPatientClinicalDiagnosis($id);
        $patients_count = count($data);
        $data = Invoice::getPatientInvoices($id);
        $invoices_count = count($data);

        $preferences = UserPreferences::getPreferences();

        return view('modules.patients.details.show', compact('preferences', 'patient', 'patients_count', 'invoices_count'));
    }

    public function opd_record($id)
    {

        $patient = Patient::find($id);
        $data = ClinicalDiagnosis::getPatientClinicalDiagnosis($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.patients.details.opd_record', compact('preferences', 'patient', 'data'));
    }

    public function invoice_record($id, Request $request)
    {

        $patient = Patient::find($id);
        $query = Invoice::query()->where('patient_id', $id);

        // Live search by receipt number
        if ($request->has('q') && !empty($request->q)) {
            $q = $request->q;
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('receipt_number', 'like',  $q . '%');
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(10);
        $preferences = UserPreferences::getPreferences();
        $page = 'invoices';
        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.patients.details.include.invoices_record_partial', compact('data', 'page'))->render(),
            ]);
        }

        return view('modules.patients.details.invoice_record', compact('preferences', 'patient', 'data'));
    }

    public function documents_list($id, Request $request)
    {
        $patient = Patient::find($id);
        $data = $patient->externalDocuments()->latest()->get();
        $preferences = UserPreferences::getPreferences();
        $page = 'documents_list';

        return view('modules.patients.details.external_documents_list', compact('preferences', 'patient', 'data'));
    }

    public function brief_histories($id, Request $request)
    {
        $patient = Patient::find($id);
        $preferences = UserPreferences::getPreferences();
        // $page = 'brief_histories';

        return view('modules.patients.details.brief_histories', compact('preferences', 'patient'));
    }

    public function lab_groups($id, Request $request)
    {
        $patient = Patient::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.patients.details.lab_groups', compact('preferences', 'patient'));
    }


    public function edit($id)
    {
        if(!checkPersonPermission('update_patients_section_6')) {
               return ErrorMessage(403);
        }
        $obj = Patient::with('emergencyContact')->find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.patients.update', compact('preferences', 'obj'));
    }


    public function detailPage($id)
    {
        $patient = Patient::findOrFail($id);
        return view('modules.patients.detail', compact('patient'));
    }


    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_patients_section_6')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Patient::find($id);
            return $obj->deleteObj();
        }
    }

    public function download_visiting_card($id)
    {

         if(!checkPersonPermission('download_visiting_card_patients_section_6')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = new Patient();
            return $obj->generateVistingCard($id);
        }
    }

    public function navbar(Request $request)
    {

        $preferences = UserPreferences::getPreferences();
        return view('modules.details.navbar', compact('preferences'));

    }

}
