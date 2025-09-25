<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use App\Models\CdDiagnosis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CdDiagnosisController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdDiagnosis();
                return $obj->addForm();

            case 'PUT':
                $obj = new CdDiagnosis();
                return $obj->updateForm();

            default:
                $obj = new CdDiagnosis();
                return $obj->addForm();
        }
    }
}
