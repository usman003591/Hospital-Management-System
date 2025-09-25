<?php

namespace App\Http\Controllers\Patient;

use App\Models\CdTreatment;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\ClinicalDiagnosis;
use App\Http\Controllers\Controller;

class PatientMedicalRecordController extends Controller
{
    public function medication_record(Request $request)
    {
        $preferences = UserPreferences::getPreferences();

        if ($request->ajax() && $request->type === 'live_search') {
            $searchTerm = $request->q;

            $query = ClinicalDiagnosis::join('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
                ->join('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
                ->join('doctors as d', 'cdd.doctor_id', 'd.id')
                ->join('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
                ->select([
                    'clinical_diagnoses.*',
                    'p.name_of_patient as patient_name',
                    'p.patient_mr_number as patient_mr_number',
                    'cdd.start_date as start_date',
                    'cdd.end_date as end_date',
                    'd.doctor_name as doctor_name',
                    'h.name as hospital_name',
                ])
                ->where('clinical_diagnoses.hospital_id', $preferences['preference']['hospital_id'])
                ->where(function ($query) use ($searchTerm) {
                    $query->where('p.patient_mr_number', 'ILIKE', "%{$searchTerm}%")
                        ->orWhere('p.name_of_patient', 'ILIKE', "%{$searchTerm}%")
                        ->orWhere('clinical_diagnoses.id', 'ILIKE', "%{$searchTerm}%");
                })
                ->distinct();

            $data = $query
                ->orderBy('clinical_diagnoses.created_at', 'desc')
                ->paginate(10);


            return response()->json([
                'status' => 200,
                'data' => view('modules.pharmacy.include.list_partial', compact('data'))->render(),
            ]);
        }

        return view('modules.pharmacy.medical_record', compact('preferences'));
    }

    public function medicine_record_in_detail(Request $request)
    {

        $id = $request->id;
        $treatment_data = CdTreatment::getTreatmentData($id);

        return response()->json([
            'status' => 200,
            'data' => view('modules.pharmacy.include.medicines_partial', compact('treatment_data'))->render(),
        ]);
    }
}
