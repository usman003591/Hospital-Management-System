<?php

namespace App\Http\Controllers\Invoices;
use Yajra\DataTables\Facades\DataTables;
use Response;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Models\InvoiceService;
use App\Models\ServiceCategory;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\InvoicePaymentStatus;

class invoicesController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_services_invoices_65')) {
               return ErrorMessage(403);
        }
        $payment_statuses = InvoicePaymentStatus::getActivePaymentStatuses();
        $hospitals = Hospital::getActiveHospitals();
        $patients = Patient::getForSelect();
        $preferences = UserPreferences::getPreferences();
        $serviceCategories = ServiceCategory::getActiveHospitalServiceCategories();

        return view('modules.invoices.create', compact('preferences', 'payment_statuses', 'patients', 'serviceCategories', 'hospitals'));
    }

    public function store(Request $request)
    {

         if(!checkPersonPermission('create_services_invoices_65')) {
               return ErrorMessage(403);
        }

        $obj = new Invoice();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {

        if(!checkPersonPermission('update_services_invoices_65')) {
               return ErrorMessage(403);
        }

        $obj = new Invoice();
        return $obj->updateForm($request);
    }

    public function fetchSpecificHospitalInvoices(Request $request)
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $page = 'invoices';
        $key = 'invoices';

        if ($request->ajax()) {

            $query = Invoice::leftJoin('patients as p', 'p.id', '=', 'invoices.patient_id')
                ->leftJoin('hospitals as h', 'h.id', '=', 'invoices.hospital_id')
                ->leftJoin('invoice_payment_statuses as ips', 'ips.id', '=', 'invoices.invoice_payment_status_id')
                ->select([
                    'invoices.*',
                    'p.name_of_patient as patient_name',
                    'h.name as hospital_name',
                    'ips.name as payment_status'
                ])
                ->where('invoices.hospital_id', $hospital_id)
                ->orderBy('invoices.created_at', 'desc');

            return DataTables::of($query)
                ->editColumn('patient_name', function ($invoice) {
                    return $invoice->patient_name ?? '-';
                })
                ->editColumn('hospital_name', function ($invoice) {
                    return $invoice->hospital_name ?? '-';
                })
                ->editColumn('payment_status', function ($invoice) {
                    return $invoice->payment_status ?? '-';
                })
                ->filter(function ($query) use ($request) {
                    if ($search = $request->get('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->where('p.name_of_patient', 'ilike', "%{$search}%")
                                ->orWhere('invoices.receipt_number', 'ilike', "%{$search}%")
                                ->orWhere('h.name', 'ilike', "%{$search}%")
                                ->orWhere('ips.name', 'ilike', "%{$search}%");
                        });
                    }
                })
                ->addColumn('action', function ($invoice) use ($page) {
                    return view('modules.invoices.include.actions', compact('invoice', 'page'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_services_invoices_65')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.invoices.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_services_invoices_65')) {
               return ErrorMessage(403);
        }
        $obj = Invoice::find($id);
        $patients = Patient::getForSelect();
        $serviceCategories = ServiceCategory::getActiveHospitalServiceCategories();

        if(auth()->user()->role_id === 1) {
           $serviceCategories = ServiceCategory::getActiveServiceCategories();
        }

        $selectedCategories = InvoiceService::getInvoiceServices($obj->id);
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();

        return view('modules.invoices.update', compact('preferences', 'obj', 'patients', 'serviceCategories', 'selectedCategories', 'hospitals'));
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_services_invoices_65')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Invoice::find($id);
            return $obj->deleteObj();
        }
    }

    public function download_invoice($id)
    {
         if(!checkPersonPermission('download_services_invoices_65')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $invoice = Invoice::find($id);
            $headers = array(
                'Content-Type: application/pdf',
            );

            return response()->file($invoice->receipt_file_full_path, [
                'Content-Type' => 'application/pdf',
            ]);
        }
    }

}
