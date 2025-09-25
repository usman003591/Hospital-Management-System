<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use Illuminate\Http\Request;
use App\Models\CdSnapHistory;
use App\Http\Controllers\Controller;

class CdSnapHistoryController extends Controller
{
    public function store(Request $request) {
        $obj = new CdSnapHistory();
        return $obj->addForm();
    }

    public function get_snapshot (Request $request) {
        $obj = new CdSnapHistory();
        return $obj->generateSnapShot();
    }
}
