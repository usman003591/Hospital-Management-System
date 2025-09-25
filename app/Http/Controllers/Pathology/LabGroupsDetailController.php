<?php

namespace App\Http\Controllers\Pathology;

use stdClass;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\LabGroup;
use App\Models\LabInvoice;
use Illuminate\Support\Str;
use App\Models\LabGroupTest;
use Illuminate\Http\Request;
use App\Models\Investigations;
use App\Models\LabInvoiceItem;
use App\Models\UserPreferences;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ClinicalDiagnosis;
use App\Models\LabGroupTestResult;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\InvestigationAttachedField;

class LabGroupsDetailController extends Controller
{
    public function detail(Request $request)
    {
        if (!checkPersonPermission('detail_lab_groups_55')) {
            return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        $obj = LabGroup::find($request->id);
        $patient = Patient::find($obj->patient_id);
        $lab_group_data = LabGroup::getLabGroupDetailsById($request->id);
        $lab_group_stats = LabGroupTest::getLabGroupTestStats($request->id);
        $investigations = Investigations::getInvestigationsByTypeAndInHouse(2);

        return view('modules.lab_groups.details.index', compact('preferences', 'obj', 'patient', 'lab_group_data', 'lab_group_stats', 'investigations'));
    }

    public function lab_tests(Request $request)
    {
        if (!checkPersonPermission('detail_lab_groups_55')) {
            return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();

        $obj = LabGroup::find($request->id);
        $patient = Patient::find($obj->patient_id);
        $lab_group_data = LabGroup::getLabGroupDetailsById($request->id);
        $lab_group_stats = LabGroupTest::getLabGroupTestStats($request->id);
        // $investigations = Investigations::getInvestigationsByTypeAndInHouse(2);
        $pathology = 2;
        $investigations = Investigations::getInvestigationsByTypeAndInHouseWithPrices($pathology);

        return view('modules.lab_groups.details.lab_tests', compact('obj', 'patient', 'lab_group_data', 'lab_group_stats', 'investigations', 'preferences'));

    }
    public function GetPatientLabTests(Request $request)
    {
        if (!checkPersonPermission('detail_lab_groups_55')) {
            return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        $obj = LabGroup::find($request->id);
        $patient = Patient::find($obj->patient_id);
        $lab_group_data = LabGroup::getLabGroupDetailsById($request->id);
        $lab_group_tests = LabGroupTest::getLabGroupTests($request->id);
        $count = count($lab_group_tests);
        // $investigations = Investigations::getInvestigationsByTypeAndInHouse(2);
        $pathology = 2;
        $investigations = Investigations::getInvestigationsByTypeAndInHouseWithPrices($pathology);

        return view('modules.patients.details.include.patient_lab_tests', compact('preferences', 'obj', 'patient', 'lab_group_data', 'lab_group_tests', 'count', 'investigations'));
    }

    public function download_result($id)
    {
        $lab_group_id = intVal($id);
        $lab_group_data = LabGroup::where('id', $lab_group_id)->first();
        if ($lab_group_data) {

            $hospitalData = Hospital::where('id', $lab_group_data->hospital_id)->first();
            $patientData = Patient::where('id', operator: $lab_group_data->patient_id)->first();
            $tests = LabGroupTest::join('lab_groups as lg','lg.id','lab_group_tests.lab_group_id')
            ->join('patients as patient','patient.id','lg.patient_id')
            ->join('investigations as investigation','investigation.id','lab_group_tests.investigation_id')
            ->where('lab_group_id', $lab_group_id)
            ->whereIn('lab_group_tests.status', ['completed', 'collected'])
            ->select(
            'lab_group_tests.*',
            'patient.id as patient_id',
            'investigation.name as investigation_name'
            )
            ->get();

            $processedTests = [];
            $allGood = true;

            if ($tests->isNotEmpty()) {
                foreach ($tests as $test) {
                    if (!is_null($test->generated_report_pdf_path)) {

                        $investigation = Investigations::where('id', $test->investigation_id)->first();
                        $testResults = LabGroupTestResult::where('lab_group_test_id', $test->id)->get();

                        if ($testResults->isNotEmpty()) {

                            $StdObj = new stdClass();
                            $StdObj->testName = $investigation->name ?? null;
                            $StdObj->testResults = $testResults;
                            $processedTests[] = $StdObj;
                            $allGood = true;

                        } else {

                            $StdObj = new stdClass();
                            $StdObj->testName = $investigation->name ?? null;
                            $StdObj->testResults = [];
                            $processedTests[] = $StdObj;
                            $allGood = false;
                        }
                    }
                }
            }

            if (empty($processedTests)) {
                $allGood = false;
            }

            $processedData = [
                'hospitalData' => $hospitalData,
                'patientData' => $patientData,
                'labGroupData' => $lab_group_data,
                'tests' => $tests,
                'processedTests' => $processedTests,
                'allGood' => $allGood,
            ];

            return $this->generateLabGroupPdf($processedData, $lab_group_data);

        }
    }

    public function download_patient_receipt ($id) {

            $lab_group_id = intVal($id);
            $lab_group_data = LabGroup::where('id', $lab_group_id)->first();
            $lab_group_tests = LabGroupTest::getLabGroupTests($lab_group_data->id);
            $lab_invoice_data = LabInvoice::where('id', $lab_group_data->lab_invoice_id)->first();
            $total_investigation_items = count($lab_group_tests);
            $fill_data_investigations = 0;
            $invoice_items = LabInvoiceItem::getInvoiceItems($lab_invoice_data->id);

            if ($total_investigation_items < 6) {
                $fill_data_investigations = 6 - $total_investigation_items;
            } else {
                $fill_data_investigations = 0;
            }

            $patient_data = Patient::withTrashed()->find($lab_group_data->patient_id);
            $doctor_data = Doctor::withTrashed()->find($lab_group_data->doctor_id);
             // $department_data = Department::find($doctor_data->department_id);
            $hospital = Hospital::find($lab_group_data->hospital_id);
            // $customPaper = array(0, 0, 567.00, 283.80);

            $lab_group_number = $lab_group_data->lab_group_number;
            $encrypted_lab_group_number = encrypt($lab_group_number);

            $button_url = config('app.url') . '/pathology/check-qr-code/' . $encrypted_lab_group_number;
            $qrCode = \QrCode::size(60)->generate($button_url);

            if ($total_investigation_items > 6) {

                    if ( $total_investigation_items  < 8) {
                            $fill_data_investigations = 8 - $total_investigation_items;
                        } else {
                            $fill_data_investigations = 0;
                        }

                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.lab_receipts.lab_collection_report_portrait', compact('lab_group_data','patient_data',
                'invoice_items','doctor_data', 'hospital', 'lab_group_tests','qrCode','lab_invoice_data','fill_data_investigations'))
                ->setPaper('a4', 'portrait');

            } else {

                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.lab_receipts.lab_collection_report_landscape', compact('lab_group_data','patient_data',
                'invoice_items','doctor_data', 'hospital', 'lab_group_tests','qrCode','lab_invoice_data','fill_data_investigations'))
                ->setPaper('a4', 'landscape');

            }

            $dir = ClinicalDiagnosis::getLabReceiptsDir();
            $extension = 'pdf';
            $FileName = strtolower(time() . '_' . rand(1000, 9999) . '.' . $extension);
            $path = public_path() . '/' . $dir;
            File::isDirectory(directory: $path) or File::makeDirectory($path, 0777, true, true);
            $pdf->save($path . $FileName);
            $file = $path . $FileName;
            $lab_group_data->receipt_name = $FileName;
            $lab_group_data->receipt_file_path = url($dir . $FileName);
            $lab_group_data->update();

            return $pdf->stream('investigations_slip_download.pdf');
    }

    public function downloadLabReport($id)
    {
        $lab_group_data = LabGroup::findOrFail($id);

        if (!$lab_group_data->generated_pdf_path || !file_exists($lab_group_data->generated_pdf_path)) {
            abort(404, 'File not found.');
        }

        return response()->download($lab_group_data->generated_pdf_path, 'lab_report.pdf');
    }

    public function generateLabGroupPdf($processedData, $obj)
    {
        $dir = LabGroup::getLabGroupTestsDir();
        $patient = Patient::where('id', $obj->patient_id)->first();
        $doctor = Doctor::where('id', $obj->doctor_id)->first();
        $hospital = Hospital::find($obj->hospital_id);

        $lab_group_number = $obj->lab_group_number;
        $encrypted_lab_group_number = encrypt($lab_group_number);

        $button_url = config('app.url') . '/pathology/check-qr-code/' . $encrypted_lab_group_number;
        $qrCode = \QrCode::size(60)->generate($button_url);

        $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('documents.lab_report.full_idc_lab_group_pathology_report', compact(
                 'processedData',
                 'obj',
                 'patient',
                 'qrCode',
                 'hospital',
                 'doctor',
                 'patient'
            ))->setPaper('A4', 'portrait');

        $filename = 'info_' . Str::ulid() . '.pdf';

        $extension = 'pdf';
        $FileName = strtolower($obj->lab_group_number . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension);
        $path = public_path() . '/' . $dir;

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $pdf->save($path . $FileName);
        $file = $path . $FileName;

        $obj->generated_pdf_path = $file;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

         return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');

    }

    public function lab_code($id)
    {

        $lab_group_id = intVal($id);
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];
        $hospital = Hospital::find($hospital_id);

        $obj = LabGroup::find($id);
        $barcodeText = $obj->lab_group_number;
        $patient_id = $obj->patient_id;
        $patient = Patient::getById($patient_id);
        $patient_name = $patient->name_of_patient;
        $mr_number = $patient->patient_mr_number;
        $button_url = config('app.url') . '/lab_groups/5/lab_tests';

        $data = [
            'barcodeText' => $barcodeText,
            'logo' => $hospital->logo,
            'qrCode' => \QrCode::size(60)->generate($button_url), // Replace with your URL or data
            'name' => $patient_name,
            'mr_number' => $mr_number
        ];

        $pdf = Pdf::loadView('documents.lab_code.qr_and_barcode', $data);
        $pdf->setPaper([0, 0, 72, 144], 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);

        return $pdf->stream('barcode-label.pdf');
    }

    public function lab_group_test_details(Request $request)
    {
        if (!checkPersonPermission('add_lab_test_data_lab_group_detail_56')) {
            // if (!checkPersonPermission('detail_lab_groups_55')) {
            return ErrorMessage(403);
        }

        $lab_group_id = $request->id;
        $lab_group_test_id = $request->test_id;

        $preferences = UserPreferences::getPreferences();
        $obj = LabGroup::find($request->id);
        $patient = Patient::find($obj->patient_id);
        $lab_group_data = LabGroup::getLabGroupDetailsById($request->id);

        $labGroupTest = LabGroupTest::where('id', $lab_group_test_id)->first();
        $investigation_id = $labGroupTest->investigation_id;

        $testDetailData = [];
        $testData = InvestigationAttachedField::leftjoin(
            'investigations_custom_fields as icf',
            'icf.id',
            'investigations_attached_fields.investigation_custom_field_id'
        )->select(
                'icf.*',
                'investigations_attached_fields.id as investigation_attached_field_id',
                'investigations_attached_fields.investigation_id as investigation_id'
            )
            ->where('investigations_attached_fields.investigation_id', $investigation_id)
            ->get();

        foreach ($testData as $key => $value) {

            $investigation_attached_field_id = $value->investigation_attached_field_id;
            $testResultData = LabGroupTestResult::where('investigation_attached_field_id', $value->investigation_attached_field_id)
                ->where('lab_group_test_id', $lab_group_test_id)
                ->first();

            if ($testResultData) {
                $value->result_value = $testResultData->value;
            } else {
                $value->result_value = null;
            }

            $testDetailData[] = $value;
        }

        return view('modules.lab_groups.details.lab_tests.add_test_data', compact(
            'preferences',
            'obj',
            'patient',
            'lab_group_data',
            'testDetailData',
            'lab_group_test_id',
            'lab_group_id'
        ));
    }

    public function save_lab_group_test_details(Request $request)
    {
        $obj = new LabGroupTestResult();
        return $obj->addForm();
    }

}
