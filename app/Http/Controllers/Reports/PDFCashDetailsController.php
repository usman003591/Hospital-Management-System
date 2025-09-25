<?php

namespace App\Http\Controllers\Reports;

use Response;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Models\InvoiceService;
use App\Models\ServiceCategory;
use App\Models\UserPreferences;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class PDFCashDetailsController extends Controller
{
    public function index (Request $request) {
       if(!checkPersonPermission('cash_details_report_reports_section_9')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $page = 'cash details';
        return view('modules.reports.cash_details.index',compact('preferences','page'));

    }

    public function store (Request $request) {

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];
        $hospital = Hospital::where('id',$hospital_id)->first();

        $date_range = explode('-',$request->date_range);
        $from_date = $date_range[0];
        $from_date = str_replace(' ', '', $from_date);
        $to_date = $date_range[1];
        $to_date = str_replace(' ', '', $to_date);

        $invoices = Invoice::leftjoin('patients as p','p.id','invoices.patient_id')
        ->leftjoin('users as user','user.id','invoices.created_by')
        ->select(
            'invoices.id',
            'invoices.receipt_number',
            'p.name_of_patient',
            'p.patient_mr_number',
            'invoices.date_issued',
            'invoices.total_amount',
            'invoices.discount_amount',
            'invoices.net_amount',
            'invoices.amount_received',
            'user.name as cashier_name'
        )
        ->whereBetween('invoices.created_at', [$from_date, $to_date])
        ->where('invoices.hospital_id',$hospital_id)
        ->get();

        $consultation_services_array = ServiceCategory::where('parent_id',1)->pluck('id')->toArray();
        $diagnostic_services_array = ServiceCategory::where('parent_id',32)->pluck('id')->toArray();
        $prosthetics_work_shop_services_array = ServiceCategory::where('parent_id',80)->pluck('id')->toArray();

        foreach ($invoices as $invoice) {

                    $invoice_services = InvoiceService::where('invoice_id',$invoice->id)->get();

                    $consultation_service_charges = 0;
                    $diagnostic_service_charges = 0;
                    $treatment_service_charges = 0;
                    $prosthetics_work_shop_service_charges = 0;

                    foreach ($invoice_services as $service) {

                            if(in_array($service->service_category_id, $consultation_services_array)) {
                                $consultation_service_charges = $consultation_service_charges + $service->price;
                            } elseif (in_array($service->service_category_id, $diagnostic_services_array)) {
                                $diagnostic_service_charges = $diagnostic_service_charges + $service->price;
                            } elseif (in_array($service->service_category_id, $prosthetics_work_shop_services_array)) {
                                $prosthetics_work_shop_service_charges = $prosthetics_work_shop_service_charges + $service->price;
                            } else {
                                $treatment_service_charges = $treatment_service_charges + $service->price;
                            }
                    }

                    $invoice->consultation_fee = isset($consultation_service_charges)?$consultation_service_charges:0;
                    $invoice->diagnostic_charges = isset($diagnostic_service_charges)?$diagnostic_service_charges:0;
                    $invoice->treatment_charges = isset($treatment_service_charges)?$treatment_service_charges:0;
                    $invoice->prosthetics_work_shop_charges = isset($prosthetics_work_shop_service_charges)?$prosthetics_work_shop_service_charges:0;
        }

        $invoices = $invoices->sortBy('receipt_number');

        return $this->generatePDF($invoices,$hospital);
    }

    public function generatePDF($invoices,$hospital)
    {
        if ($invoices) {

            $total_consultation_fee = 0;
            $total_diagnostic_fee = 0;
            $total_treatment_fee = 0;
            $total_prosthetics_fee = 0;
            $total_amount = 0;
            $total_discount_amount = 0;
            $total_net_amount = 0;
            $total_recieved_amount = 0;

            foreach ($invoices as $invoice) {

                $total_consultation_fee =  $total_consultation_fee + $invoice->consultation_fee;
                $total_diagnostic_fee =  $total_diagnostic_fee + $invoice->diagnostic_charges;
                $total_treatment_fee =  $total_treatment_fee + $invoice->treatment_charges;
                $total_prosthetics_fee =  $total_prosthetics_fee + $invoice->prosthetics_work_shop_charges;
                $total_amount =  $total_amount + $invoice->total_amount;
                $total_discount_amount =  $total_discount_amount + $invoice->discount_amount;
                $total_net_amount =  $total_net_amount + $invoice->net_amount;
                $total_recieved_amount =  $total_recieved_amount + $invoice->amount_received;

            }

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('documents.cash_details.cash_details', compact('invoices','hospital','total_consultation_fee','total_diagnostic_fee','total_treatment_fee',
            'total_prosthetics_fee','total_amount','total_discount_amount','total_net_amount','total_recieved_amount'))
            ->setPaper('A4', 'landscape');

            return $pdf->download('cash_detail_report.pdf');
        }
    }
}
