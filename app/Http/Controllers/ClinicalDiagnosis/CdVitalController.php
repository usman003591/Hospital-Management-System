<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use App\Models\CdVital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CdVitalController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdVital();
                return $obj->addForm();

            case 'PUT':
                $obj = new CdVital();
                return $obj->updateForm();

            default:
                $obj = new CdVital();
                return $obj->addForm();
        }
    }

    public function registration_vitals_form (Request $request) {


        switch ($request->method()) {
            case 'POST':
                $obj = new CdVital();
                return $obj->addVitalForm();

            case 'PUT':
                $obj = new CdVital();
                return $obj->updateVitalForm();

            default:
                $obj = new CdVital();
                return $obj->addVitalForm();
        }
    }
}
