<?php

namespace App\Http\Controllers\Finance\Verification;

use App\Models\LabInvoice;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\FinanceVerificationAuditLog;

class PathologyInvoiceVerificationController extends Controller
{
    public function index (Request $request)
    {
        if(!checkPersonPermission('list_pathology_invoices_verification_64')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.finance.verification.pathology.index',compact('preferences'));
    }

    public function show_details($id)
    {
        if(!checkPersonPermission('detail_pathology_invoices_verification_64')) {
               return ErrorMessage(403);
        }

        $obj = LabInvoice::find($id);
        if (!$obj) {
            return redirect()->back()->with('error', 'Pathology Invoice not found.');
        }
        $preferences = UserPreferences::getPreferences();
        $logs = FinanceVerificationAuditLog::getLogsByInvoiceId($id, $type = 'lab_invoices');

        return view('modules.finance.verification.pathology.show_details', compact('id', 'preferences','obj', 'logs'));
    }

    public function download_pathology_invoice ($id) {
        if(!checkPersonPermission('download_pathology_invoices_verification_64')) {
            return ErrorMessage(403);
        }

        $obj = LabInvoice::find($id);
        if (!$obj) {
            return redirect()->back()->with('error', 'Pathology Invoice not found.');
        }
        // Logic to download the pathology invoice
        if ($obj) {
            return response()->file($obj->receipt_file_full_path, [
                'Content-Type' => 'application/pdf',
            ]);
        }

    }

}
