<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\InvoiceService;
use App\Models\ServiceCategory;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class MonthlyInvoicesExport implements FromCollection,WithHeadings,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $date = Carbon::today()->subDays(30);
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
        ->where('invoices.created_at','>=',$date)
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

        return $invoices;

    }

    public function headings() :array
    {
        return ["Unique Number","Receipt Number", "Name Of Patient",'Patient Mr Number',"Date Issued", "Total Amount",'Discount Amount','Net Amount','Amount Received','Cashier Name','consultation_fee','diagnostic_charges','treatment_charges','prosthetics_work_shop_charges'];
    }

}
