<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use App\Models\CdDisposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CdDisposalController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':
                $obj = new CdDisposal();
                return $obj->addForm();
                break;

            case 'PUT':
                $obj = new CdDisposal();
                return $obj->addForm();
                break;

            default:
                $obj = new CdDisposal();
                return $obj->addForm();
                break;
        }
    }
}
