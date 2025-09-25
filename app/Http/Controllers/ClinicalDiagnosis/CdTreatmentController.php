<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use App\Models\CdTreatment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CdTreatmentController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdTreatment();
                return $obj->addForm();
                break;

            case 'PUT':
                $obj = new CdTreatment();
                return $obj->updateForm();
                break;

            default:
                $obj = new CdTreatment();
                return $obj->addForm();
                break;
        }
    }
}
