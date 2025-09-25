<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\ClinicalDiagnosis;


class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $module = $request->input('module');

        if (!$query || !$module) {
            return redirect()->back()->with('error', 'Please enter an ID and select a module');
        }

        $moduleModels = [
            'patients' => Patient::class,
            'clinical_diagnoses' => ClinicalDiagnosis::class,
        ];

        if (!isset($moduleModels[$module])) {
            return redirect()->back()->with('error', 'Invalid module selected');
        }

        $model = $moduleModels[$module];
        $record = null;

        // Normalize CNIC query (remove dashes for comparison)
        $normalizedQuery = str_replace('-', '', $query);

        if ($module == 'patients') {
            $record = $model::where(function ($q) use ($query, $normalizedQuery) {
                $q->where('patient_mr_number', 'ILIKE', $query.'%')
                    ->orWhereRaw("REPLACE(cnic_number, '-', '') = ?", [$normalizedQuery])
                    ->orWhere('name_of_patient', 'ILIKE', "{$query}%")
                    ->orWhere('cell', 'ILIKE', "{$query}%");

                if (is_numeric($query)) {
                    $q->orWhere('id', $query)->orWhere('cell', $query);
                }
            })->first();
        }

        if ($module == 'clinical_diagnoses') {
            $record = $model::join('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
                ->select('clinical_diagnoses.*')
                ->where(function ($q) use ($query, $normalizedQuery) {
                    $q->where('p.patient_mr_number', 'ILIKE', "%{$query}%")
                        ->orWhereRaw("REPLACE(p.cnic_number, '-', '') = ?", [$normalizedQuery])
                        ->orWhere('p.cell', 'ILIKE', "{$query}%");;

                    if (is_numeric($query)) {
                        $q->orWhere('clinical_diagnoses.id', $query);
                    }
                })
                ->latest()
                ->first();
        }

        if (!$record) {
            return redirect()->back()->with('error', 'Record not found');
        }

        $moduleRoutes = [
            'patients' => route('patients.detail_page', ['id' => $record->id]),
            'clinical_diagnoses' => route('clinical_diagnosis.detail_form', ['id' => $record->id]),
        ];

        return redirect($moduleRoutes[$module]);
    }

}

