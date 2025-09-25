<?php

namespace App\Http\Controllers\Reports;

use App\Models\Invoice;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function create (Request $request) {
       if(!checkPersonPermission('create_reports_section_9')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $page = 'reports';
        return view('modules.reports.create',compact('preferences','page'));

    }

    public function store (Request $request) {
        if(!checkPersonPermission('download_reports_section_9')) {
               return ErrorMessage(403);
        }
        $obj = new Invoice();
        return $obj->generateReport();
    }

}
