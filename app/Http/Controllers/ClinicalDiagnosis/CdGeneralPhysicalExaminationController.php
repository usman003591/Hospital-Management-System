<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralPhysicalExamination;
use App\Models\CdGeneralPhysicalExamination;

class CdGeneralPhysicalExaminationController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdGeneralPhysicalExamination();
                return $obj->addForm();
                break;

            case 'PUT':
                $obj = new CdGeneralPhysicalExamination();
                return $obj->updateForm();
                break;

            default:
                $obj = new CdGeneralPhysicalExamination();
                return $obj->addForm();
                break;
        }
    }
}
