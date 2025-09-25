<?php

namespace App\Http\Controllers\Reports;

use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class PDFPatientDetailsController extends Controller
{
    public function index (Request $request) {
          if(!checkPersonPermission('patient_details_prescription_report_reports_section_9')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $page = 'patient details';
        return view('modules.reports.patient_details.prescription',compact('preferences','page'));
    }

    public function store (Request $request) {

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];
        $hospital = Hospital::where('id',$hospital_id)->first();

        $date_range = explode('-',$request->date_range);
        $from_date = $date_range[0];
        $from_date = str_replace(' ', '', $from_date);
        $to_date = $date_range[1];
        $to_date = str_replace(' ', '', $to_date);

        $patientsData = Patient::join('prescriptions as pres', 'pres.patient_id','patients.id')
        ->join('doctors as doc','pres.doctor_id','doc.id')
        ->select([
            'patients.*',
            'doc.doctor_name'
         ])
        ->where('pres.hospital_id',$hospital_id)
        ->whereBetween('pres.created_at', [$from_date, $to_date])
        ->get();

        //dd( $patientsData);

        return $this->generatePDF($patientsData,$hospital);
    }

    public function generatePDF($patientsData,$hospital) {

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        ->loadView('documents.patient_record.patient_record', compact('patientsData','hospital'))
        ->setPaper('A4', 'landscape');

        return $pdf->download('cash_detail_report.pdf');

    }

}
