<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use App\Http\Controllers\Controller;
use App\Models\CdProcedure;
use Illuminate\Http\Request;

class CdProcedureController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdProcedure();
                return $obj->addForm();

            case 'PUT':
                $obj = new CdProcedure();
                return $obj->updateForm();

            default:
                $obj = new CdProcedure();
                return $obj->addForm();
        }
    }
}
