<?php

namespace App\Models;

use Response;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\PDF;
use App\Models\InvoiceService;
use App\Models\ServiceCategory;
use App\Models\UserPreferences;
use App\Exports\DailyInvoicesExport;
use App\Models\InvoicePaymentStatus;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WeeklyInvoicesExport;
use App\Exports\MonthlyInvoicesExport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['patient_id', 'date_issued', 'total_amount', 'invoice_payment_status_id', 'discount_amount', 'net_amount', 'amount_received', 'receipt_number', 'receipt_file_name', 'receipt_file_full_path', 'total_services', 'created_by', 'updated_by', 'deleted_by', 'hospital_id'];
    public static function getAll()
    {
        $request = request();
        //dd($request->all());
        $search['page'] = $request->has('page') ? $request->get('page') : 1;
        $search['per_page'] = $request->has('per_page') ? $request->get('per_page') : 10;

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['hospital'] = $request->has('hospital') ? $request->get('hospital') : false;

        $data = self::leftJoin('patients as p', 'p.id', '=', 'invoices.patient_id')
            ->leftJoin('hospitals as h', 'h.id', '=', 'invoices.hospital_id')
            ->leftJoin('invoice_payment_statuses as ips', 'ips.id', '=', 'invoices.invoice_payment_status_id')
            ->select([
                'invoices.*',
                'p.name_of_patient',
                'h.name as hospital_name',
                'ips.name as payment_status'
            ]);


        if ($search['q']) {
            $data = $data->where('invoices.receipt_number', 'iLIKE', "%{$search['q']}%")
                ->orWhere('p.name_of_patient', 'iLIKE', '%' . $search['q'] . '%');
                // ->orWhere('p.invoice_sequence', 'iLIKE', '%' . $search['q'] . '%');
        }

        if ($search['hospital']) {
            $data = $data->where('invoices.hospital_id', $search['hospital']);
        }


        // dd($data->get());
        return [
            'search' => $search,
            'data' => $data->orderBy('invoices.created_at', 'desc')->paginate(perPage: $search['per_page'])
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(InvoicePaymentStatus::class, 'invoice_payment_status_id');
    }

    public static function getInvoicesStatsForFinance () {

        $stats_total_count = self::get()->count();
        $verified_invoices_count = self::where('is_finance_verified',1)->count();
        $unverified_invoices_count = self::where('is_finance_verified',0)->count();

        $stats = [];

        $stats['total_invoices'] = $stats_total_count;
        $stats['verified_invoices'] = $verified_invoices_count;
        $stats['unverified_invoices'] = $unverified_invoices_count;

        return $stats;
    }

    public static function getPatientInvoices($patient_id)
    {
        $data = self::leftjoin('invoice_payment_statuses as ips', 'ips.id', 'invoices.invoice_payment_status_id')
            ->select(['invoices.*', 'ips.name as payment_status'])
            ->where('invoices.patient_id', $patient_id)
            ->orderBy('invoices.created_at', 'desc')
            ->paginate(10);

        return $data;
    }

    public function addForm(Request $request)
    {
        $request->validate(
            [
                'patient_id' => ['required', 'exists:patients,id'],
                'hospital_id' => ['required'],
                'discount_amount' => ['required', 'max_digits:3', 'numeric', 'min:0', 'max:100'],
                'services' => ['required', 'array'],
                'services.*' => ['required'],
            ],
            [
                'patient_id.required' => 'Patient is required',
                'services.required' => 'At least one service is required.',
            ]
        );

        $hospital = Hospital::find($request->hospital_id);
        $now = Carbon::now();

        $obj = new Invoice;
        $obj->patient_id = $request->patient_id;
        $obj->date_issued = Carbon::parse($now);
        $obj->total_amount = 0;
        $obj->invoice_payment_status_id = 1;
        $obj->hospital_id = $request->hospital_id;
        $obj->discount_amount = $request->discount_amount;
        $obj->net_amount = 0;
        $obj->amount_received = 0;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        $price = 0;
        $total_amount = 0;
        $total_services = 0;
        $filldata_services = 0;
        $discount_amount = 0;
        $patient = null;

        if ($request->services) {
            $services = $request->services;
            foreach ($services as $service) {
                $patient = Patient::find($obj->patient_id);
                if ($patient->patient_category) {
                    $priceObj = ServiceCategory::getAmountCharged($patient->patient_category, $service);
                    $price = (integer) $priceObj['0'];
                    $matchThese = ['invoice_id' => $obj->id, 'service_category_id' => $service];
                    InvoiceService::updateOrCreate($matchThese, ['price' => $price, 'created_by' => auth()->user()->id]);
                    $total_amount = $total_amount + $price;
                    $total_services++;
                }
            }
        }

        // Special employee discount from 25 Nov 2024 till 31 March 2025
        // $employee_discount_message = '';
        // $employee_discount_message = false;
        // $special_employee_discount_status = false;

        // if ($hospital->id == 1 || $hospital->id == 2) {
            // if ($request->discount_amount == 'no_discount') {
            //     $discount_amount = 0;
            //     $current_date = Carbon::now();
            //     $discount_date = '2025-06-30';
            //     $discount_date = Carbon::parse($discount_date);
            //     $discount_employee_date = '2025-06-30';
            //     $discount_employee_date = Carbon::parse($discount_employee_date);

            //     if ($patient->patient_category === 'employee') {


            //         if ($discount_employee_date > $current_date) {
            //             $discount_amount = $total_amount;
            //             $special_employee_discount_status = true;
            //         } else {
            //             $discount_amount = 0;
            //         }

            //     } else if ($patient->patient_category === 'resident' || $patient->patient_category === 'non_resident') {

            //         if ($discount_date > $current_date) {
            //             $discount_rate = 0.50;
            //             $discount_amount = $discount_rate * $total_amount;
            //         } else {
            //             $discount_amount = 0;
            //         }
            //     }
            // }
        // } else {
        //     $discount_amount = 0;
        // }

        // if ($request->discount_amount == 'full_discount') {
        //     $discount_amount = $total_amount;
        // }

        // $obj->discount_amount = $discount_amount;
        // $obj->update();

        // $net_amount = $total_amount - $obj->discount_amount;
        // $amount_received = $total_amount - $obj->discount_amount;

        // $obj->net_amount = $net_amount;
        // $obj->amount_received = $amount_received;
        $obj->total_amount = $total_amount;

        $discount_amount = ($obj->discount_amount/100)*$total_amount;
        $obj->net_amount = $total_amount - $discount_amount;
        $obj->amount_received = $obj->net_amount;
        $obj->discount_amount = $discount_amount;
        $obj->receipt_number = intval($obj->id) + 1000;
        $obj->invoice_sequence = generateSequence($obj->receipt_number);
        $obj->update();

        if ($total_services < 6) {
            $filldata_services = 6 - $total_services;
        }

        return $this->generatePDF($filldata_services, $obj, $patient, $total_services, $hospital);
    }


    public function updateForm(Request $request)
    {
        $request->validate(
            [
                'patient_id' => ['required', 'exists:patients,id'],
                'hospital_id' => ['required'],
                'discount_amount' => ['required', 'max_digits:3', 'numeric', 'min:0', 'max:100'],
                'services' => ['required', 'array'],
                'services.*' => ['required'],
            ],
            [
                'patient_id.required' => 'Patient is required',
                'services.required' => 'At least one service is required.',
            ]
        );

        $hospital = Hospital::find($request->hospital_id);
        $date_issued = Carbon::createFromFormat('d/m/Y h:i A', $request->date_issued)->format('Y-m-d H:i:s');

        $obj = Invoice::find($request->id);
        $obj->patient_id = $request->patient_id;
        $obj->date_issued = $date_issued;
        $obj->total_amount = 0;
        $obj->invoice_payment_status_id = 1;
        $obj->hospital_id = $request->hospital_id;
        $obj->discount_amount = $request->discount_amount;
        $obj->net_amount = 0;
        $obj->amount_received = 0;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        $price = 0;
        $total_amount = 0;
        $total_services = 0;
        $filldata_services = 0;
        $discount_amount = 0;
        $patient = null;

        InvoiceService::where('invoice_id', $obj->id)->delete();
        $patient = Patient::find($obj->patient_id);

        if ($request->services) {
            $services = $request->services;
            foreach ($services as $service) {
                if ($patient->patient_category) {
                    $priceObj = ServiceCategory::getAmountCharged($patient->patient_category, $service);
                    $price = (integer) $priceObj['0'];
                    if (InvoiceService::where('invoice_id', '=', $obj->id)->where('service_category_id', $service)->withTrashed()->exists()) {
                        InvoiceService::where('invoice_id', $obj->id)->where('service_category_id', $service)->withTrashed()->restore();
                        $newObj = InvoiceService::where('invoice_id', $obj->id)->where('service_category_id', $service)->first();
                        $newObj->updated_by = auth()->user()->id;
                        $newObj->save();
                    } else {
                        $matchThese = ['invoice_id' => $obj->id, 'service_category_id' => $service];
                        InvoiceService::updateOrCreate($matchThese, ['price' => $price, 'created_by' => auth()->user()->id]);
                    }
                    $total_amount = $total_amount + $price;
                    $total_services++;
                }
            }
        }

        // Special employee discount from 25 Nov 2024 till 31 March 2025
        // $employee_discount_message = '';
        // $employee_discount_message = false;
        // $special_employee_discount_status = false;

        // if ($hospital->id == 1 || $hospital->id == 2) {
        //     if ($request->discount_amount == 'no_discount') {

        //         $discount_amount = 0;
        //         $current_date = Carbon::now();
        //         $discount_date = '2025-06-30';
        //         $discount_date = Carbon::parse($discount_date);
        //         $discount_employee_date = '2025-06-30';
        //         $discount_employee_date = Carbon::parse($discount_employee_date);

        //         if ($patient->patient_category === 'employee') {

        //             if ($discount_employee_date > $current_date) {
        //                 $discount_amount = $total_amount;
        //                 $special_employee_discount_status = true;
        //             } else {
        //                 $discount_amount = 0;
        //             }

        //         } else if ($patient->patient_category === 'resident' || $patient->patient_category === 'non_resident') {
        //             if ($discount_date > $current_date) {
        //                 $discount_rate = 0.50;
        //                 $discount_amount = $discount_rate * $total_amount;
        //             } else {
        //                 $discount_amount = 0;
        //             }
        //         }
        //     }
        // } else {
        //     $discount_amount = 0;
        // }

        // if ($request->discount_amount == 'full_discount') {
        //     $discount_amount = $total_amount;
        // }

        // $obj->discount_amount = $discount_amount;
        // $obj->update();

        // $net_amount = $total_amount - $obj->discount_amount;
        // $amount_received = $total_amount - $obj->discount_amount;

        $obj->total_amount = $total_amount;

        $discount_amount = ($obj->discount_amount/100)*$total_amount;
        $obj->net_amount = $total_amount - $discount_amount;
        $obj->amount_received = $obj->net_amount;
        $obj->discount_amount = $discount_amount;
        $obj->receipt_number = intval($obj->id) + 1000;
        $obj->update();

        if ($total_services < 6) {
            $filldata_services = 6 - $total_services;
        }

        return $this->generatePDF($filldata_services, $obj, $patient, $total_services, $hospital);
    }

    public static function getDailyInvoiceStatsData()
    {

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $date = Carbon::now()->format('Y-m-d');
        $invoices = self::leftjoin('patients as p', 'p.id', 'invoices.patient_id')
            ->select(
                'invoices.receipt_number',
                'p.name_of_patient',
                'p.patient_mr_number',
                'invoices.date_issued',
                'invoices.total_amount',
                'invoices.discount_amount',
                'invoices.net_amount',
                'invoices.amount_received'
            )
            ->whereDate('invoices.created_at', Carbon::parse($date))
            ->where('invoices.hospital_id', '=', $hospital_id)
            ->get();

        $data['count'] = count($invoices);
        $data['total_amount'] = $invoices->sum('total_amount');
        $data['received_amount'] = $invoices->sum('amount_received');
        $data['discount_amount'] = $invoices->sum('discount_amount');

        return $data;
    }

    public static function getWeeklyInvoiceStatsData()
    {

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $date = Carbon::today()->subDays(7);
        $invoices = self::leftjoin('patients as p', 'p.id', 'invoices.patient_id')
            ->select(
                'invoices.receipt_number',
                'p.name_of_patient',
                'p.patient_mr_number',
                'invoices.date_issued',
                'invoices.total_amount',
                'invoices.discount_amount',
                'invoices.net_amount',
                'invoices.amount_received'
            )
            ->where('invoices.created_at', '>=', $date)
            ->where('invoices.hospital_id', '=', $hospital_id)
            ->get();

        // $data['count'] = count($invoices);
        $data['total_amount'] = $invoices->sum('total_amount');
        $data['received_amount'] = $invoices->sum('amount_received');
        $data['discount_amount'] = $invoices->sum('discount_amount');

        return $data;
    }

    public static function getInvoicesCount()
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        return self::where('invoices.hospital_id', '=', $hospital_id)
            ->count();
    }

    public static function getMonthlyInvoiceStatsData()
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];
        $date = Carbon::today()->subDays(30);
        $invoices = self::leftjoin('patients as p', 'p.id', 'invoices.patient_id')
            ->select(
                'invoices.receipt_number',
                'p.name_of_patient',
                'p.patient_mr_number',
                'invoices.date_issued',
                'invoices.total_amount',
                'invoices.discount_amount',
                'invoices.net_amount',
                'invoices.amount_received'
            )
            ->where('invoices.created_at', '>=', $date)
            ->where('invoices.hospital_id', '=', $hospital_id)
            ->get();

        $data['count'] = count($invoices);
        $data['total_amount'] = $invoices->sum('total_amount');
        $data['received_amount'] = $invoices->sum('amount_received');
        $data['discount_amount'] = $invoices->sum('discount_amount');

        return $data;
    }

    public function generatePDF($filldata_services, $obj, $patient, $total_services, $hospital)
    {
        $invoice_services = InvoiceService::getInvoiceServices($obj->id);

        if ($total_services <= 6) {

            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.receipts.new_reciept', compact('patient', 'invoice_services', 'filldata_services', 'obj', 'hospital'))
                ->setPaper('A4', 'landscape');

        } else {

            $customPaper = array(0, 0, 700, 1000);
            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.receipts.latest', compact('patient', 'invoice_services', 'filldata_services', 'obj', 'hospital'))
                ->setPaper($customPaper, 'portrait');
        }

        $dir = self::getInvoicesDir();
        $extension = 'pdf';
        $FileName = strtolower(time() . '_' . rand(1000, 9999) . '.' . $extension);
        $path = public_path() . '/' . $dir;
        File::isDirectory(directory: $path) or File::makeDirectory($path, 0777, true, true);
        $pdf->save($path . $FileName);
        $file = $path . $FileName;
        $obj->receipt_file_name = $FileName;
        $obj->receipt_file_full_path = $file;
        $obj->update();

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->stream(function () use ($file) {
            readfile($file);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($file) . '"',
        ]);

    }

    public static function getInvoicesDir()
    {
        return 'assets/invoices/';
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Receipt has been deleted successfully',
        ]);
    }

    public function generateReport($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'invoice_duration' => ['required'],
        ], [
            'invoice_duration.required' => 'Please select invoice duration',
        ]);

        switch ($request->invoice_duration) {
            case 'daily':
                return Excel::download(new DailyInvoicesExport, 'daily_invoices.xlsx');
                break;
            case 'weekly':
                return Excel::download(new WeeklyInvoicesExport, 'weekly_invoices.xlsx');
                break;
            case 'monthly':
                return Excel::download(new MonthlyInvoicesExport, 'monthly_invoices.xlsx');
                break;
            default:
                return Excel::download(new DailyInvoicesExport, 'daily_invoices.xlsx');
        }

        session()->flash('success', 'Report downloaded successfully');
        return Redirect::route('reports.create');

    }
}
