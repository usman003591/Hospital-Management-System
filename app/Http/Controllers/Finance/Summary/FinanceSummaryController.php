<?php

namespace App\Http\Controllers\Finance\Summary;

use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class FinanceSummaryController extends Controller
{
    public function getSummary(Request $request)
    {

        if(!checkPersonPermission('view_summary_summary_70')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        $hospitals = Hospital::select('id', 'name')->get();

        return view('modules.finance.summary.index',compact('preferences','hospitals'));
    }

    public function DownloadSummary(Request $request)
    {
        // $preferences = UserPreferences::getPreferences();
        // return view('modules.finance.summary',compact('preferences'));
    }
}
