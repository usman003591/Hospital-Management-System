<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use Illuminate\Http\Request;
use App\Models\CdBriefHistory;
use App\Http\Controllers\Controller;

class CdBriefHistoryController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdBriefHistory();
                return $obj->addForm();
                break;

            case 'PUT':
                $obj = new CdBriefHistory();
                return $obj->updateForm();
                break;

            default:
                $obj = new CdBriefHistory();
                return $obj->addForm();
                break;
        }
    }
}
