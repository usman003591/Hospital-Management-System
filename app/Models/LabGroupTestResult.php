<?php

namespace App\Models;

use Response;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
// use Barryvdh\DomPDF\PDF;
use App\Models\Hospital;
use App\Models\LabGroup;
use App\Models\LabGroupTest;
use App\Jobs\GenerateInvoice;
use App\Models\Investigations;
use App\Models\InvoiceService;
use App\Models\ServiceCategory;
use App\Models\UserPreferences;
use App\Exports\DailyInvoicesExport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WeeklyInvoicesExport;
use App\Exports\MonthlyInvoicesExport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabGroupTestResult extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'lab_group_test_id',
        'investigation_attached_field_id',
        'value',
        'reference_value',
        'mark_normal',
        'name',
        'unit',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function test()
    {
        return $this->belongsTo(LabGroupTest::class, 'lab_group_test_id');
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $lab_group_id = $request->id;
        $lab_group_test_id = $request->test_id;

        $request->validate([
            'lab_group_test_data.*.value' => 'required|string|min:0',
        ], [
            'lab_group_test_data.*.value.required' => 'This test value is required.',
            'lab_group_test_data.*.value.string' => 'This test value must be a number.',
        ]);

        // Validate with custom messages
        try {

            $lab_data = [];
            foreach ($request->lab_group_test_data as $fieldId => $data) {

                $value = $data['value'];
                $processedData = $this->processData($fieldId, $value, $lab_group_id);

                $matchThese = ['lab_group_test_id' => $lab_group_test_id, 'investigation_attached_field_id' => $fieldId];
                $labGroupTestResultObj = LabGroupTestResult::updateOrCreate($matchThese, [
                    'value' => $processedData->value,
                    'reference_value' => $processedData->reference_value,
                    'name' => $processedData->name,
                    'unit' => $processedData->unit,
                    'mark_normal' => $processedData->mark_normal,
                    'created_by' => auth()->user()->id,
                ]);

                $lab_data[] = $labGroupTestResultObj;
            }

            // $lab_group_test_result_data = self::labGroupTestResultData($lab_group_test_id);

            $lab_test = LabGroupTest::where('id',$lab_group_test_id)->first();
            $lab_test->status = 'completed';
            $lab_test->update();

            $this->generatePdfResult($lab_data, $lab_group_id, $lab_group_test_id);

            session()->flash('success', 'Lab test saved successfully');
            return Redirect::route('lab_groups.lab_tests',['id'=> $lab_group_id ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Error processing lab test data: ' . $e->getMessage());
            return back();
        }
    }

    // public static function labGroupTestResultData ($testId) {
    //         $data = LabGroupTestResult::where(column: 'lab_group_test_id',$testId)->orderBy('created_at', 'asc')->get();
    //         return $data;
    // }

    public function generatePdfResult ($lab_test_data, $lab_group_id, $lab_group_test_id) {

        $lab_group_test_data = LabGroupTest::where('id', $lab_group_test_id)->first();
        $lab_group_data = LabGroup::find($lab_group_id);
        $patient = Patient::where('id', $lab_group_data->patient_id)->first();
        $investigationId = $lab_group_test_data->investigation_id;
        $patientId = $lab_group_data->patient_id;

        $resultsData = LabGroupTest::with('results')
        ->whereHas('group', fn($q) => $q->where('patient_id', $patientId))
        ->where('investigation_id', $investigationId)
        ->orderBy('report_date', 'desc')
        ->take(4)
        ->get();

        $allParameters = $resultsData->flatMap(fn($t) => $t->results->pluck('name'))->unique();

        $pivotedResults = [];
        foreach ($allParameters as $param) {
            $row = [
                'name' => $param,
                'reference_value' => null,
                'unit' => null,
            ];
            foreach ($resultsData as $index => $test) {
                $colKey = \Carbon\Carbon::parse($test->report_date)->format('d M Y') . " (#" . ($index+1) . ")";
                $row[$colKey] = '-';

                $res = $test->results->firstWhere('name', $param);

                if ($res) {

                    if (!$row['reference_value']) {
                        $row['reference_value'] = $res->reference_value;
                        $row['unit'] = $res->unit;
                    }

                    $result_value = null;

                    if ($res->mark_normal) {
                        $result_value = $res->value;
                    } else {
                        $result_value = "<b><u>{$res->value}</u></b>";
                    }

                    $row[$colKey] = $result_value;


                }
            }

            $pivotedResults[] = $row;
        }
        // dd($resultsData );
        $doctor = Doctor::where('id', $lab_group_data->doctor_id)->first();
        $hospital = Hospital::find($lab_group_data->hospital_id);
        $obj = LabGroupTest::find($lab_group_test_id);

        $labTestData = LabGroupTestResult::where('lab_group_test_id', $lab_group_test_id)->get();
        $investigation = Investigations::find($obj->investigation_id);

        $lab_group_number = $lab_group_data->lab_group_number;
        $encrypted_lab_group_number = encrypt($lab_group_number);

        $button_url = config('app.url') . '/pathology/check-qr-code/' . $encrypted_lab_group_number;
        $qrCode = \QrCode::size(60)->generate($button_url);

        $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('documents.lab_report.idc_lab_group_pathology_report', compact(
                'patient',
                'hospital',
                'resultsData',
                'pivotedResults',
                'lab_group_data',
                'lab_test_data',
                'doctor',
                'obj',
                'investigation',
                'qrCode'
            ))
            ->setPaper('A4', 'portrait');

        $dir = self::getLabTestsDir();
        $extension = 'pdf';

        $FileName = strtolower(time() . '_' . rand(1000, 9999) . '.' . $extension);
        $path = public_path() . '/' . $dir;
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $pdf->save($path . $FileName);

        $file = $dir . $FileName;
        // $obj->status = 'collected';
        $obj->generated_report_pdf_path = $file;
        $obj->update();

    }

    public function generatePDF($lab_test_data, $lab_group_id, $lab_group_test_id)
    {

        $lab_group_data = LabGroup::find($lab_group_id);
        $patient = Patient::where('id', $lab_group_data->patient_id)->first();
        $doctor = Doctor::where('id', $lab_group_data->doctor_id)->first();
        $hospital = Hospital::find($lab_group_data->hospital_id);
        $obj = LabGroupTest::find($lab_group_test_id);
        $investigation = Investigations::find($obj->investigation_id);

        $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('documents.lab_report.pathology_report', compact(
                'patient',
                'hospital',
                'lab_group_data',
                'lab_test_data',
                'doctor',
                'obj',
                'investigation'
            ))
            ->setPaper('A4', 'landscape');

        $dir = self::getLabTestsDir();
        $extension = 'pdf';

        $FileName = strtolower(time() . '_' . rand(1000, 9999) . '.' . $extension);
        $path = public_path() . '/' . $dir;
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $pdf->save($path . $FileName);

        $file = $dir . $FileName;
        $obj->status = 'collected';
        $obj->generated_report_pdf_path = $file;
        $obj->update();

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, $FileName, $headers);

    }

    public static function getLabTestsDir()
    {
        return 'assets/lab_tests/';
    }



    public function processData($fieldId, $value, $lab_group_id)
    {

        $attachedFieldData = InvestigationAttachedField::getCustomAttachedFieldData($fieldId);

        $reference_value_min = null;
        $reference_value_max = null;

        $labGroupData = LabGroup::leftjoin('patients as patient', 'patient.id', 'lab_groups.patient_id')
            ->select('patient.gender')
            ->where('lab_groups.id', $lab_group_id)
            ->first();

        switch ($labGroupData->gender) {
            case 'male':

                $reference_value_min = $attachedFieldData->male_reference_min;
                $reference_value_max = $attachedFieldData->male_reference_max;

                break;

            case 'female':

                $reference_value_min = $attachedFieldData->female_reference_min;
                $reference_value_max = $attachedFieldData->female_reference_max;

                break;

            default:

                $reference_value_min = $attachedFieldData->all_reference_min;
                $reference_value_max = $attachedFieldData->all_reference_max;

        }

        $isNormal = true;
        $reference_value = null;

        // dd($attachedFieldData->reference_notes);

        if (!is_null($attachedFieldData->reference_notes)) {

            $isNormal = true;
            $reference_value = $attachedFieldData->reference_notes;

        } else {

            $reference_value = $reference_value_min . ' - ' . $reference_value_max;
            $isNormal = $this->calculateIfInvestigationData($reference_value_min, $reference_value_max, $value);
        }

        $dataObj = new \stdClass();
        $dataObj->reference_value_min = $reference_value_min;
        $dataObj->reference_value_max = $reference_value_max;
        $dataObj->mark_normal = $isNormal;
        $dataObj->value = $value;
        $dataObj->reference_value = $reference_value;
        $dataObj->name = $attachedFieldData->name;
        $dataObj->unit = $attachedFieldData->unit;
        $dataObj->attachedFieldData = $attachedFieldData;

        return $dataObj;
    }

    public function calculateIfInvestigationData($min, $max, $result_value)
    {
        $min = (float) $min;
        $max = (float) $max;
        $result_value = (float) $result_value;

        $is_normal = false;
        if ($result_value >= $min && $result_value <= $max) {
            $is_normal = true;

        } else {
            $is_normal = false;
        }

        return $is_normal;
    }

}
