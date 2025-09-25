<?php

namespace App\Http\Controllers\Lab;

use App\Models\Patient;
use App\Models\Hospital;
use App\Models\LabInvoice;
use Illuminate\Http\Request;
use App\Models\Investigations;
use App\Models\LabInvoiceItem;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class LabSectionInvoicesController extends Controller
{
    public function index(Request $request)
    {
        if(!checkPersonPermission('list_lab_invoices_60')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.lab_invoices.index', compact('preferences'));
    }

    public function create(Request $request)
    {
         if(!checkPersonPermission('create_lab_invoices_60')) {
               return ErrorMessage(403);
        }

        $patients = Patient::getForSelect();
        $preferences = UserPreferences::getPreferences();
        $pathology = 2;
        $investigations = Investigations::getInvestigationsByTypeAndInHouseWithPrices($pathology);

        return view('modules.lab_invoices.create', compact('preferences','patients','investigations'));
    }

    public function store(Request $request)
    {
        if(!checkPersonPermission('create_lab_invoices_60')) {
               return ErrorMessage(403);
        }

        $obj = new LabInvoice();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {
        if(!checkPersonPermission('update_lab_invoices_60')) {
               return ErrorMessage(403);
        }

        $obj = LabInvoice::find($request->id);
        return $obj->updateForm($request);
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_lab_invoices_60')) {
               return ErrorMessage(403);
        }

        $obj = LabInvoice::find($id);
        $patients = Patient::getForSelect();
        $pathology = 2;
        $investigations = Investigations::getInvestigationsByTypeAndInHouseWithPrices($pathology);
        $selected_investigations = LabInvoiceItem::getInvoiceInvestigations($obj->id);
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();

        return view('modules.lab_invoices.update', compact('preferences', 'obj', 'patients', 'investigations', 'selected_investigations', 'hospitals'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_lab_invoices_60')) {
               return ErrorMessage(403);
        }

        if ($id) {
            $obj = LabInvoice::find($id);
            return $obj->deleteObj();
        }
    }

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
