<?php

namespace App\Http\Controllers\Lab;

use App\Models\LabInvoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LabSectionInvoicesDownloadController extends Controller
{
    public function download_invoice($id)
    {
        if(!checkPersonPermission('download_lab_invoices_60')) {
               return ErrorMessage(403);
        }

        if ($id) {
            $invoice = LabInvoice::find($id);
            $headers = array(
                'Content-Type: application/pdf',
            );

            return response()->file($invoice->receipt_file_full_path, [
                'Content-Type' => 'application/pdf',
            ]);
        }
    }
}
