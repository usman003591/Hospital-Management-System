<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystematicPhysicalExamination;
use App\Models\CdSystematicPhysicalExamination;

class CdSystematicPhysicalExaminationController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdSystematicPhysicalExamination();
                return $obj->addForm();
                break;

            case 'PUT':
                $obj = new CdSystematicPhysicalExamination();
                return $obj->updateForm();
                break;

            default:
                $obj = new CdSystematicPhysicalExamination();
                return $obj->addForm();
                break;
        }
    }
}
