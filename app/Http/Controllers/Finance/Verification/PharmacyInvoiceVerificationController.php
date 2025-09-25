<?php

namespace App\Http\Controllers\Finance\Verification;

use App\Models\PosInvocie;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\FinanceVerificationAuditLog;

class PharmacyInvoiceVerificationController extends Controller
{
    public function index (Request $request)
    {
         if(!checkPersonPermission('list_pharmacy_invoices_verification_63')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.finance.verification.pharmacy.index',compact('preferences'));
    }

    public function show_details($id)
    {

        if(!checkPersonPermission('detail_pharmacy_invoices_verification_63')) {
               return ErrorMessage(403);
        }

        $obj = PosInvocie::find($id);
        if (!$obj) {
            return redirect()->back()->with('error', 'Pos Invoice not found.');
        }
        $logs = FinanceVerificationAuditLog::getLogsByInvoiceId($id, $type = 'pos_invoices');
        $preferences = UserPreferences::getPreferences();

        return view('modules.finance.verification.pharmacy.show_details', compact('id', 'preferences','obj','logs'));
    }

    public function download_pharmacy_invoice ($id) {
        if(!checkPersonPermission('download_pharmacy_invoices_verification_63')) {
            return ErrorMessage(403);
        }

        $obj = PosInvocie::find($id);
        if (!$obj) {
            return redirect()->back()->with('error', 'Pos Invoice not found.');
        }

        if ($obj) {
            return redirect($obj->invoice_file_path);
        }
    }
}
