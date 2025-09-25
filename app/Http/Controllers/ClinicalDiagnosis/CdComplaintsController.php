<?php

namespace App\Http\Controllers\ClinicalDiagnosis;

use App\Models\CdComplaint;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CdComplaintsController extends Controller
{
    public function store(Request $request) {
        switch ($request->method()) {
            case 'POST':

                $obj = new CdComplaint();
                return $obj->addForm();
                break;

            case 'PUT':
                $obj = new CdComplaint();
                return $obj->updateForm();
                break;

            default:
                $obj = new CdComplaint();
                return $obj->addForm();
                break;
        }
    }
}
