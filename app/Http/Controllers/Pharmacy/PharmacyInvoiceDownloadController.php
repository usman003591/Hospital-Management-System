<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\PosInvocie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PharmacyInvoiceDownloadController extends Controller
{
     public function download_invoice($id)
    {
        if ($id) {

            $invoice = PosInvocie::find($id);
            if(!$invoice) { abort(404); }
            $headers = array(     'Content-Type: application/pdf',   );
            return response()->file($invoice->invoice_file_path, [
                'Content-Type' => 'application/pdf',
            ]);
        }
    }
}
