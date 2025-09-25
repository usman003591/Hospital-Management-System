<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use Illuminate\Http\Request;
use App\Models\CdInvestigations;
use App\Http\Controllers\Controller;

class CdInvestigationsController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdInvestigations();
                return $obj->addForm();
                break;

            case 'PUT':
                $obj = new CdInvestigations();
                return $obj->updateForm();
                break;

            default:
                $obj = new CdInvestigations();
                return $obj->addForm();
                break;
        }
    }
}
