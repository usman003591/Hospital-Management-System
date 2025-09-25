<?php

namespace App\Http\Controllers\Pathology;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\LabGroup;
use App\Models\LabGroupTest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Investigations;
use App\Models\UserPreferences;
use App\Models\LabGroupTestResult;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\InvestigationAttachedField;

class LabTestsController extends Controller
{
    public function lab_test_download($test_id)
    {
        $obj = LabGroupTest::find($test_id);
        $generated_report_pdf_path = $obj->generated_report_pdf_path;
        $dir = LabGroupTestResult::getLabTestsDir();
        $filePath = public_path($generated_report_pdf_path);
        $lab_test = LabGroupTest::where('id', $test_id)->first();
        $lab_test->status = 'collected';
        $lab_test->received_date = Carbon::now();
        $lab_test->update();

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        $fileName = 'lab_report_data_' . $test_id;
        $fileSize = filesize($filePath);
        $mimeType = 'application/pdf';

        return response()->stream(function () use ($filePath) {
            $stream = fopen($filePath, 'r');
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
            'Content-Length' => $fileSize,
            'Cache-Control' => 'no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    public function change_status(Request $request)
    {
        $status = $request->status;
        if (!checkPersonPermission('change_lab_test_status_lab_group_detail_56')) {
            return ucfirst($status);
        }
        $id = $request->id;
        $data = LabGroupTest::changeStatus($id, $status);
        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    public function delete($id = false)
    {
        if ($id) {
            $obj = LabGroupTest::find($id);
            return $obj->deleteObj();
        }
    }

    public function save_lab_group_investigations(Request $request, $id)
    {
        if ($id) {
            return LabGroupTest::addMoreInvestigations($id);
        }
    }


}
