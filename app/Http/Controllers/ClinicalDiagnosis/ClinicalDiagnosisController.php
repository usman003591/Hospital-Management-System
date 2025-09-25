<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use Carbon\Carbon;
use App\Models\Vital;
use App\Models\Doctor;
use App\Models\CdVital;
use App\Models\Patient;
use App\Models\CdDoctor;
use App\Models\Hospital;
use App\Models\LabGroup;
use App\Models\Complaint;
use App\Models\Diagnosis;
use App\Models\Medicines;
use App\Models\Procedure;
use App\Models\CdDisposal;
use App\Models\Department;
use App\Models\DosageForm;
use App\Models\OPDCounter;
use App\Models\CdComplaint;
use App\Models\CdDiagnosis;
use App\Models\CdProcedure;
use App\Models\CdTreatment;
use Illuminate\Http\Request;
use App\Models\CdSnapHistory;
use App\Models\MedicineRoute;
use App\Models\CdBriefHistory;
use App\Models\Investigations;
use App\Models\TreatmentDosage;
use App\Models\UserPreferences;
use App\Models\CdInvestigations;
use App\Models\MedicineDuration;
use App\Models\CdComplaintDetail;
use App\Models\CdDiagnosisDetail;
use App\Models\ClinicalDiagnosis;
use App\Models\DiagnosisCategory;
use App\Models\TreatmentDuration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TreatmentDoseInterval;
use Yajra\DataTables\Facades\DataTables;
use App\Models\GeneralPhysicalExamination;
use App\Models\CdGeneralPhysicalExamination;
use App\Models\SystematicPhysicalExamination;
use App\Models\CdSystematicPhysicalExamination;
use App\Models\CdGeneralPhysicalExaminationDetail;
use App\Models\CdSystematicPhysicalExaminationDetail;

class ClinicalDiagnosisController extends Controller
{
    public function fetchSpecificClinicalDiagnosis(Request $request)
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];
        $page = 'clinical_diagnosis';

        $query = ClinicalDiagnosis::leftJoin('patients as patient', 'patient.id', 'clinical_diagnoses.patient_id')
            ->leftJoin('hospitals as h', 'h.id', '=', 'clinical_diagnoses.hospital_id')
            ->leftjoin('o_p_d_counters as counter', 'counter.id', 'clinical_diagnoses.counter_id')
            ->leftJoin('cd_doctors as cdd', 'cdd.cd_id', '=', 'clinical_diagnoses.id')
            ->leftJoin('doctors as d', 'cdd.doctor_id', '=', 'd.id')
            ->select([
                'clinical_diagnoses.id',
                'clinical_diagnoses.status',
                'clinical_diagnoses.token_number',
                'counter.name as counter_name',
                'patient.name_of_patient as patient_name',
                'patient.patient_mr_number',
                'd.doctor_name as doctor_name',
                'h.name as hospital_name',
            ])
            ->where('clinical_diagnoses.hospital_id', $hospital_id)
            ->orderBy('clinical_diagnoses.created_at', 'desc');

        return DataTables::of($query)
            ->editColumn('patient_name', function ($diagnosis) {
                return $diagnosis->patient_name ?? '-';
            })
            ->addColumn('counter_token', function ($diagnosis) {
                return $diagnosis->counter_name . ' / ' . $diagnosis->token_number;
            })
            ->editColumn('hospital_name', function ($diagnosis) {
                return $diagnosis->hospital_name ?? '-';
            })
            ->editColumn('patient_mr_number', function ($diagnosis) {
                return $diagnosis->patient_mr_number ?? '-';
            })
            ->editColumn('doctor_name', function ($diagnosis) {
                return $diagnosis->doctor_name ?? '-';
            })
            ->editColumn('status', function ($diagnosis) {
                return $diagnosis->status ?? '-';
            })

            ->filter(function ($query) use ($request) {
                if ($search = $request->get('search')['value']) {
                    $query->where(function ($q) use ($search) {
                        $q->where('patient.name_of_patient', 'ilike', "%{$search}%")
                            ->orWhere('d.doctor_name', 'ilike', "%{$search}%")
                            ->orWhere('clinical_diagnoses.token_number', 'ilike', "%{$search}%")
                            ->orWhere('counter.name', 'ilike', "%{$search}%");
                    });
                }
            })
            ->addColumn('action', function ($diagnosis) use ($page) {
                return view('modules.clinical_diagnosis.include.actions', compact('diagnosis', 'page'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index(Request $request)
    {
        if (!checkPersonPermission('list_all_49')) {
            return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $page = 'clinical_diagnosis';
        return view('modules.clinical_diagnosis.index', compact('preferences', 'page'));
    }

    public function dailyListingRecord(Request $request)
    {

        $d = ClinicalDiagnosis::getDailyRecord();
        $preferences = UserPreferences::getPreferences();
        // $doctors = Doctor::getForSelect();
        $doctors = Doctor::getUsersLoggedInHospitalDoctors();
        $hospitals = Hospital::getActiveHospitals();

        $page = 'clinical_diagnosis';
        $data = $d['data'];
        $search = $d['search'];

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.clinical_diagnosis.include.logged_in_doctor_list_partial', compact('data', 'page', 'search'))->render(),
            ]);
        }
        return view('modules.clinical_diagnosis.daily', compact('preferences', 'page', 'search', 'data', 'doctors', 'hospitals'));
    }


    public function myAllListingRecord(Request $request)
    {

        if (!checkPersonPermission('list_doctor_opd_50')) {
            return ErrorMessage(403);
        }

        $d = ClinicalDiagnosis::getMyAllRecord();
        $preferences = UserPreferences::getPreferences();
        $doctors = Doctor::getForSelect();
        $hospitals = Hospital::getActiveHospitals();

        $page = 'clinical_diagnosis';
        $data = $d['data'];
        $search = $d['search'];

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.clinical_diagnosis.include.logged_in_doctor_list_partial', compact('data', 'page', 'search'))->render(),
            ]);
        }
        return view('modules.clinical_diagnosis.loged_in_doctor_all_record', compact('preferences', 'page', 'search', 'data', 'doctors', 'hospitals'));

    }

    public function myDailyListingRecord(Request $request)
    {
        if (!checkPersonPermission('list_doctor_opd_50')) {
            return ErrorMessage(403);
        }

        $d = ClinicalDiagnosis::getMyDailyRecord();
        $preferences = UserPreferences::getPreferences();
        $doctors = Doctor::getForSelect();
        $hospitals = Hospital::getActiveHospitals();

        $page = 'clinical_diagnosis';
        $data = $d['data'];
        $search = $d['search'];

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.clinical_diagnosis.include.logged_in_doctor_list_partial', compact('data', 'page', 'search'))->render(),
            ]);
        }
        return view('modules.clinical_diagnosis.loged_in_doctor_record', compact('preferences', 'page', 'search', 'data', 'doctors', 'hospitals'));

    }

    public function create(Request $request)
    {

        if (!checkPersonPermission('create_all_49')) {
            return ErrorMessage(403);
        }
        $complaints = Complaint::getParentComplaints();
        $child_complaints = Complaint::getAllChildComplaints();
        $preferences = UserPreferences::getPreferences();
        $patients = Patient::getForSelect();
        $doctors = Doctor::getUsersLoggedInHospitalDoctors();
        $hospitals = Hospital::getActiveHospitals();
        $counters = OPDCounter::getActiveCounters();

        return view('modules.clinical_diagnosis.create', compact('counters', 'preferences', 'complaints', 'child_complaints', 'patients', 'doctors', 'hospitals'));
    }

    public function store(Request $request)
    {
        $obj = new ClinicalDiagnosis();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new ClinicalDiagnosis();
        return $obj->updateForm();
    }

    public function edit($id)
    {

        if (!checkPersonPermission('update_all_49')) {
            return ErrorMessage(403);
        }
        $obj = ClinicalDiagnosis::find($id);
        $preferences = UserPreferences::getPreferences();
        $doctors = Doctor::getUsersLoggedInHospitalDoctors();
        $patients = Patient::getForSelect();
        $doctor_info = CdDoctor::where('cd_id', $obj->id)->first();
        $hospitals = Hospital::getActiveHospitals();

        return view('modules.clinical_diagnosis.update', compact('preferences', 'obj', 'doctor_info', 'doctors', 'patients', 'hospitals'));
    }

    public function change_status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $data = ClinicalDiagnosis::changeStatus($id, $status);
        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    public function download_sanpshot(Request $request)
    {
        $sanpshot_unique_number = $request->sanpshot_unique_number;
        if ($sanpshot_unique_number) {
            $obj = new CdSnapHistory();
            return $obj->downloadSnapFromUrl($sanpshot_unique_number);
        }
    }

    public function vitals_form(Request $request)
    {
        if (!checkPersonPermission('vitals_all_49')) {
            return ErrorMessage(403);
        }

        $cd_id = $request->id;
        try {

            $preferences = UserPreferences::getPreferences();
            $doctor_info = CdDoctor::where('cd_id', $request->id);
            $obj = ClinicalDiagnosis::find($request->id);
            $patient = Patient::find($obj->patient_id);
            $vitals = Vital::getActiveVitals();
            $CdVital = CdVital::where('cd_id', $cd_id)->get();

            if ($CdVital->isEmpty()) {
                $CdVital = null;
            }

            $tab = 'vitals';
            $page = 'vitals';
            $sc = 'vitals';

            return view('modules.clinical_diagnosis.detail.vitals', compact(
                'preferences',
                'vitals',
                'doctor_info',
                'obj',
                'patient',
                'page',
                'CdVital',
                'sc'
            ));

        } catch (\Exception $e) {
            session()->flash('error', 'Error processing procedure data: ' . $e->getMessage());
            return back();
        }
    }

    public function investigations_form(Request $request)
    {

        if (!checkPersonPermission('view_section_pathology_lab_section_54')) {
            return ErrorMessage(403);
        }
        $cd_id = $request->id;
        try {

            $preferences = UserPreferences::getPreferences();
            $doctor_info = CdDoctor::where('cd_id', $request->id);
            $obj = ClinicalDiagnosis::find($request->id);
            $patient = Patient::find($obj->patient_id);
            $lab_group_data = LabGroup::where('clinical_diagnosis_id', $request->id)->first();

            $radiology = 1;
            $pathology = 2;
            $rehablitation = 3;

            $radiology_tests = Investigations::getInvestigationsByType($radiology);
            $pathology_tests = Investigations::getInvestigationsByTypeAndInHouseWithPrices($pathology);
            $rehablitation_tests = Investigations::getInvestigationsByType($rehablitation);

            $CdInvestigationsRadiology = CdInvestigations::getInvestigationsData($obj->id, 1);
            $CdInvestigationsPathology = CdInvestigations::getInvestigationsData($obj->id, 2);
            $CdInvestigationsRehablitation = CdInvestigations::getInvestigationsData($obj->id, 3);
            //$investigations = Investigations::getInvestigationsByTypeAndInHouse(2);
            $pathology = 2;
            $investigations = Investigations::getInvestigationsByTypeAndInHouseWithPrices($pathology);

            if ($CdInvestigationsPathology->isEmpty()) {
                $CdInvestigationsPathology = null;
            }

            $tab = 'investigations';
            $page = 'investigations';
            $sc = 'investigations';
            $CdObj = $obj;

            return view('modules.clinical_diagnosis.detail.investigations', compact(
                'preferences',
                'doctor_info',
                'CdObj',
                'patient',
                'page',
                'sc',
                'radiology_tests',
                'pathology_tests',
                'CdInvestigationsRadiology',
                'CdInvestigationsPathology',
                'CdInvestigationsRehablitation',
                'investigations',
                'lab_group_data'
            ));

        } catch (\Exception $e) {
            session()->flash('error', 'Error processing procedure data: ' . $e->getMessage());
            return back();
        }
    }

    public function performDoctorAssignmentCheck($cd_id)
    {
        $cd_doctor_diagnosis_data = CdDoctor::where('cd_id', $cd_id)->withTrashed()->first();
        if (is_null($cd_doctor_diagnosis_data)) {
            $user_type = auth()->user()->user_type;
            if ($user_type === 'Doctor') {
                $doctor_data = Doctor::where('user_id', auth()->user()->id)->first();

                $today = Carbon::today();
                $CdDoctorObj = new CdDoctor;
                $CdDoctorObj->cd_id = $cd_id;
                $CdDoctorObj->start_date = Carbon::parse($today);
                $CdDoctorObj->end_date = Carbon::parse($today);
                $CdDoctorObj->doctor_id = $doctor_data->id; // Assign selected doctor
                $CdDoctorObj->updated_by = auth()->user()->id;
                $CdDoctorObj->save();
                return $CdDoctorObj;

            }
        }
    }

    public function detail_form(Request $request)
    {
        if (!checkPersonPermission('detail_all_49')) {
            return ErrorMessage(403);
        }
        $cd_id = $request->id;

        try {

            $CdDoctorObj = $this->performDoctorAssignmentCheck($cd_id);
            $complaints = Complaint::getParentComplaints();
            $child_complaints = Complaint::getAllChildComplaints();

            $diagnosis_categories = DiagnosisCategory::getActiveDiagnosisCategories();

            $preferences = UserPreferences::getPreferences();
            $doctor_info = CdDoctor::where('cd_id', $request->id);
            $obj = ClinicalDiagnosis::find($request->id);
            $patient = Patient::find($obj->patient_id);
            $vitals = Vital::getActiveVitals();

            $general_physical_examinations = GeneralPhysicalExamination::getParentPhysicalExaminations();
            $child_general_physical_examinations = GeneralPhysicalExamination::getAllChildPhysicalExaminations();
            $systematic_physical_examinations = SystematicPhysicalExamination::getParentSystematicPhysicalExamination();
            $child_systematic_physical_examinations = SystematicPhysicalExamination::getAllChildSystematicPhysicalExamination();

            $diagnosis = Diagnosis::join('cd_diagnoses as cdd', 'cdd.diagnosis_id', 'diagnosis.id')
                ->select('diagnosis.*')
                ->where('diagnosis.status', 1)->where('diagnosis.verification_status', '!=', 'rejected')
                ->get();

            $medicines = Medicines::join('cd_treatments as cdt', 'cdt.medicine_id', 'medicines.id')
                ->select('medicines.*')
                ->where('medicines.status', 1)->where('medicines.verification_status', '!=', 'rejected')
                ->get();
            // $diagnosis = null;

            $procedure = Procedure::where('status', 1)->whereNotIn('verification_status', ['rejected'])->get();
            // $child_diagnosis = Diagnosis::getAllChilDiagnosis();

            $radiology = 1;
            $pathology = 2;
            $rehablitation = 3;
            $durations = MedicineDuration::getActiveDuration();

            $radiology_tests = Investigations::getInvestigationsByType($radiology);
            $pathology_tests = Investigations::getInvestigationsByType($pathology);
            $rehablitation_tests = Investigations::getInvestigationsByType($rehablitation);

            // $medicines = Medicines::getForSelect()->whereNotIn('verification_status', ['rejected']);
            $treatment_dosage = TreatmentDosage::getForSelect();
            $treatment_interval = TreatmentDoseInterval::getForSelect();
            $treatment_duration = TreatmentDuration::getForSelect();
            $treatment_forms = DosageForm::getForSelect();
            $treatment_routes = MedicineRoute::getForSelect();

            $cdComplaintData = CdComplaint::where('cd_id', $cd_id)->get();
            if (isset($cdComplaintData)) {
                foreach ($cdComplaintData as $val) {
                    $details_data = CdComplaintDetail::where('cd_complaint_id', $val->id)->get()->toArray();
                    if ($details_data) {
                        $val->detail_data = $details_data;
                    }
                }
            }

            if ($cdComplaintData->isEmpty()) {
                $cdComplaintData = null;
            }

            $cdCdBriefHistory = CdBriefHistory::where('cd_id', $cd_id)->first();

            $CdVital = CdVital::where('cd_id', $cd_id)->get();

            if ($CdVital->isEmpty()) {
                $CdVital = null;
            }

            $CdGeneralPhysicalExaminationData = CdGeneralPhysicalExamination::where('cd_id', $cd_id)->get();
            if (isset($CdGeneralPhysicalExaminationData)) {
                foreach ($CdGeneralPhysicalExaminationData as $val) {
                    $details_data = CdGeneralPhysicalExaminationDetail::where('cd_gpe_id', $val->id)->get()->toArray();
                    if ($details_data) {
                        $val->detail_data = $details_data;
                    }
                }
            }

            if ($CdGeneralPhysicalExaminationData->isEmpty()) {
                $CdGeneralPhysicalExaminationData = null;
            }

            $CdSystematicPhysicalExaminationData = CdSystematicPhysicalExamination::where('cd_id', $cd_id)->get();
            if (isset($CdSystematicPhysicalExaminationData)) {
                foreach ($CdSystematicPhysicalExaminationData as $val) {
                    $details_data = CdSystematicPhysicalExaminationDetail::where('cd_systematic_physical_examination_id', $val->id)->get()->toArray();
                    if ($details_data) {
                        $val->detail_data = $details_data;
                    }
                }
            }

            if ($CdSystematicPhysicalExaminationData->isEmpty()) {
                $CdSystematicPhysicalExaminationData = null;
            }

            $CdInvestigationsRadiology = CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 1)->get();
            $CdInvestigationsPathology = CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 2)->get();
            $CdInvestigationsRehablitation = CdInvestigations::where('cd_id', $cd_id)->where('investigation_type_id', 3)->get();

            if ($CdInvestigationsRadiology->isEmpty()) {
                $CdInvestigationsRadiology = null;
            }

            if ($CdInvestigationsPathology->isEmpty()) {
                $CdInvestigationsPathology = null;
            }

            if ($CdInvestigationsRehablitation->isEmpty()) {
                $CdInvestigationsRehablitation = null;
            }

            $CdDiagnosisData = CdDiagnosis::where('cd_id', $cd_id)->get();
            $CdProcedureData = CdProcedure::where('cd_id', $cd_id)->get();

            if ($CdDiagnosisData->isEmpty()) {
                $CdDiagnosisData = null;
            }
            if ($CdProcedureData->isEmpty()) {
                $CdProcedureData = null;
            }

            $CdTreatmentData = CdTreatment::where('cd_id', $cd_id)->get();

            if ($CdTreatmentData->isEmpty()) {
                $CdTreatmentData = null;
            }

            $CdDisposalData = CdDisposal::where('cd_id', $cd_id)->first();

            // if ($CdDisposalData->isEmpty()) {
            //     $CdDisposalData = null;
            // }
            $doctorsData = Doctor::get(["doctor_name as name", "id"]);
            $hospitalsData = getHospitals();


            $tab = 'complaints';

            $page = 'clinical_diagnosis';
            $sc = 'Clinical Diagnosis';
            $user = Auth::user();
            $layout = 'opd_modern_layout';


            if ($user && $user->role && strtolower($user->role->name) == 'doctor') {
                $doctor = Doctor::where('user_id', $user->id)->first();

                if ($doctor) {
                    if ($doctor->opd_layout == 'simple') {
                        $layout = 'opd_simple_layout';
                    } elseif ($doctor->opd_layout == 'advanced') {
                        $layout = 'opd_advanced_layout';
                    } elseif ($doctor->opd_layout == 'modern') {
                        $layout = 'opd_modern_layout';
                    }
                }
            }


            return view('modules.clinical_diagnosis.detail.index', compact(
                'preferences',
                'complaints',
                'child_complaints',
                'vitals',
                'obj',
                'general_physical_examinations',
                'child_general_physical_examinations',
                'systematic_physical_examinations',
                'child_systematic_physical_examinations',
                'diagnosis',
                'radiology_tests',
                'pathology_tests',
                'rehablitation_tests',
                'medicines',
                'treatment_dosage',
                'treatment_interval',
                'treatment_duration',
                'cdComplaintData',
                'cdCdBriefHistory',
                'CdVital',
                'tab',
                'CdGeneralPhysicalExaminationData',
                'CdSystematicPhysicalExaminationData',
                'CdInvestigationsRadiology',
                'CdInvestigationsPathology',
                'CdInvestigationsRehablitation',
                'CdDiagnosisData',
                'CdTreatmentData',
                'patient',
                'page',
                'sc',
                'CdProcedureData',
                'procedure',
                'treatment_forms',
                'treatment_routes',
                'CdDisposalData',
                'doctorsData',
                'hospitalsData',
                'durations',
                'diagnosis_categories',
                'layout'
            ));

        } catch (\Exception $e) {
            session()->flash('error', 'Error processing procedure data: ' . $e->getMessage());
            return back();
        }


    }

    public function delete($id = false)
    {

        if (!checkPersonPermission('delete_all_49')) {
            return ErrorMessage(403);
        }
        if ($id) {
            $obj = ClinicalDiagnosis::find($id);
            return $obj->deleteObj();
        }
    }

    public function download_opd_slip($id)
    {
        if (!checkPersonPermission('download_all_49')) {
            return ErrorMessage(403);
        }
        if ($id) {
            $obj = new ClinicalDiagnosis();
            return $obj->generateFromHtmlPlainOpdSlip($id);
        }
    }
    public function fetchPatientHistory(Request $request)
    {

        if ($request->clinical_diagnosis_id) {
            $obj = ClinicalDiagnosis::where('id', $request->clinical_diagnosis_id)->first();
            if ($obj->patient_id) {
                $data = ClinicalDiagnosis::getPatientClinicalDiagnosisHistory($obj->patient_id);
                return response()->json([
                    'status' => 200,
                    'html' => view('modules.clinical_diagnosis.detail.partials.patient_history_partial', compact('data'))->render(),
                ]);
            }
        }
    }
    public function fetch_disposal_data(Request $request)
    {
        $disposal_type = $request->disposal_type;
        $label = '';
        $placeholder = '';
        $data = collect();

        switch ($disposal_type) {
            case 'referred_to_hospital':
                $data = getHospitals();
                $label = 'Refer to Hospital';
                $placeholder = 'Select Hospital';
                break;

            case 'referred_to_specialist':
                $data = Doctor::where('is_specialist', true)->get(["id", "doctor_name as name"]);
                $label = 'Refer to Specialist';
                $placeholder = 'Select Specialist';
                break;

            case 'referred_to_department':
                $data = Department::get(["id", "name as name"]);
                $label = 'Refer to Department';
                $placeholder = 'Select Department';
                break;
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'html' => view('include.opd.disposal_values', compact('data', 'label', 'placeholder'))->render(),
            ]);
        }
    }
    public function previewOPDRecords($id)
    {
        if (!checkPersonPermission('preview_all_49')) {
            return ErrorMessage(403);
        }
        $obj = new ClinicalDiagnosis();
        return $obj->getPreviewData($id);
    }
    public function generate_investigations_record(Request $request)
    {
        // Validate the request data
        $cd_id = $request->cd_id;

        if (null === $cd_id) {
            session()->flash('error', 'Clinical Diagnosis ID is required');
            return redirect()->back();
        }

        if ($cd_id) {
            $validated = $request->validate([
                // 'cd_id' => 'required|exists:clinical_diagnoses,id',
                'kt_docs_repeater_advanced_pathology.*.pathology' => ['sometimes', 'nullable'],
            ]);
            // Generate the investigations record
            $obj = ClinicalDiagnosis::find($cd_id);
            $repeater_data = request('kt_docs_repeater_advanced_pathology');
            $result = $obj->generateInvestigationsRecord($repeater_data, $request->discount_percentage);
            // Return the response
            return $result;
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

}
