<?php

namespace App\Http\Controllers\Finance\Verification;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\FinanceVerificationAuditLog;

class ServiceCategoriesInvoiceVerificationController extends Controller
{
    public function index (Request $request)
    {
        if(!checkPersonPermission('list_service_invoices_verification_62')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.finance.verification.service_categories.index',compact('preferences'));
    }

    public function show_details($id)
    {
        if(!checkPersonPermission('detail_service_invoices_verification_62')) {
               return ErrorMessage(403);
        }

        $obj = Invoice::find($id);
        if (!$obj) {
            return redirect()->back()->with('error', 'Service Invoice not found.');
        }
        $preferences = UserPreferences::getPreferences();
        $logs = FinanceVerificationAuditLog::getLogsByInvoiceId($id, $type = 'services_invoices');

        return view('modules.finance.verification.service_categories.show_details', compact('id', 'preferences','obj','logs'));
    }

    public function download_service_category_invoice ($id) {
        if(!checkPersonPermission('download_service_invoices_verification_62')) {
            return ErrorMessage(403);
        }

        $obj = Invoice::find($id);
        if (!$obj) {
            return redirect()->back()->with('error', 'Service Invoice not found.');
        }

        // Logic to download the service invoice
        if ($obj) {
            return response()->file($obj->receipt_file_full_path, [
                'Content-Type' => 'application/pdf',
            ]);
        }


    }

}
