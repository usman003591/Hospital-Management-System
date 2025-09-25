<?php

namespace App\Models;

use Response;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Hospital;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Jobs\GenerateInvoice;
use App\Models\InvoiceService;
use App\Models\LabInvoiceItem;
use App\Models\ServiceCategory;
use App\Models\UserPreferences;
use App\Exports\DailyInvoicesExport;
use App\Models\InvoicePaymentStatus;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WeeklyInvoicesExport;
use App\Models\LabInvestigationPrice;
use App\Exports\MonthlyInvoicesExport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabInvoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'lab_group_id',
        'patient_id',
        'date_issued',
        'total_amount',
        'invoice_payment_status_id',
        'discount_amount',
        'discount_percentage',
        'net_amount',
        'amount_received',
        'receipt_number',
        'receipt_file_name',
        'receipt_file_full_path',
        'total_investigation_items',
        'created_by',
        'updated_by',
        'deleted_by',
        'hospital_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public static function getInvoicesDir()
    {
        return 'assets/lab_invoices/';
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

    public function addForm(Request $request)
    {
        $request->validate(
            [
                'patient_id' => ['required', 'exists:patients,id'],
                'hospital_id' => ['required'],
                // 'discount_amount' => ['required', 'max_digits:3', 'numeric', 'min:0', 'max:100'],
                'discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
                'investigations' => ['required', 'array'],
                'investigations.*' => ['required'],
            ],
            [
                'patient_id.required' => 'Patient is required',
                'investigations.required' => 'At least one investigation is required.',
            ]
        );

        $hospital = Hospital::find($request->hospital_id);
        $now = Carbon::now();

        $obj = new LabInvoice;
        $obj->patient_id = $request->patient_id;
        $obj->date_issued = Carbon::parse($now);
        $obj->total_amount = 0;
        $obj->hospital_id = $request->hospital_id;
        $obj->discount_amount = 0; // This is not used anymore, but kept for backward compatibility
        $obj->discount_percentage = $request->discount_percentage;
        $obj->net_amount = 0;
        $obj->amount_received = 0;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        $price = 0;
        $total_amount = 0;
        $total_investigation_items = 0;
        $filldata_services = 0;
        $discount_amount = 0;
        $patient = null;

        if ($request->investigations) {
            $investigations = $request->investigations;
            foreach ($investigations as $investigation) {
                $patient = Patient::find($obj->patient_id);
                if ($patient->patient_category) {
                    $priceObj = LabInvestigationPrice::getInvestigationPrice($investigation);
                    $price = (integer) $priceObj->price;
                    LabInvoiceItem::Create([
                        'price' => $price,
                        'investigation_price_id' => $priceObj->id,
                        'lab_invoice_id' => $obj->id,
                        'investigation_id' => $investigation,
                        'created_by' => auth()->user()->id
                    ]);
                    $total_amount = $total_amount + $price;
                    $total_investigation_items++;
                }
            }
        }

        $obj->total_amount = $total_amount;
        $discount_amount = ($obj->discount_percentage/100)*$total_amount;
        $obj->net_amount = $total_amount - $discount_amount;
        $obj->amount_received = $obj->net_amount;
        $obj->discount_amount = $discount_amount;
        $obj->receipt_number = intval($obj->id) + 1000;
        $obj->invoice_sequence = generateLabSequenceInvoice($obj->receipt_number);
        $obj->update();

        if ($total_investigation_items < 6) {
            $filldata_investigations = 6 - $total_investigation_items;
        }

        return $this->generatePDF($filldata_investigations, $obj, $patient, $total_investigation_items, $hospital);
    }

    public function updateForm(Request $request)
    {
         $request->validate(
            [
                'patient_id' => ['required', 'exists:patients,id'],
                'hospital_id' => ['required'],
                'discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
                'investigations' => ['required', 'array'],
                'investigations.*' => ['required'],
            ],
            [
                'patient_id.required' => 'Patient is required',
                'investigations.required' => 'At least one investigation is required.',
            ]
        );

        $hospital = Hospital::find($request->hospital_id);
        $date_issued = Carbon::createFromFormat('d/m/Y h:i A', $request->date_issued)->format('Y-m-d H:i:s');
        $now = Carbon::now();

        $obj = LabInvoice::find($request->id);
        $obj->patient_id = $request->patient_id;
        $obj->date_issued = Carbon::parse($now);
        $obj->total_amount = 0;
        $obj->hospital_id = $request->hospital_id;
        $obj->discount_amount = 0; // This is not used anymore, but kept for backward compatibility
        $obj->discount_percentage = $request->discount_percentage;
        $obj->net_amount = 0;
        $obj->amount_received = 0;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        $price = 0;
        $total_amount = 0;
        $total_investigation_items = 0;
        $filldata_services = 0;
        $discount_amount = 0;
        $patient = null;

        if ($request->investigations) {
            $investigations = $request->investigations;
            foreach ($investigations as $investigation) {
                $patient = Patient::find($obj->patient_id);
                if ($patient->patient_category) {
                    $priceObj = LabInvestigationPrice::getInvestigationPrice($investigation);
                    $price = (integer) $priceObj->price;

                    if (LabInvoiceItem::where('lab_invoice_id', '=', $obj->id)->where('investigation_id', $investigation)->withTrashed()->exists()) {
                        LabInvoiceItem::where('lab_invoice_id', $obj->id)->where('investigation_id', $investigation)->withTrashed()->restore();
                        $newObj = LabInvoiceItem::where('lab_invoice_id', $obj->id)->where('investigation_id', $investigation)->first();
                        $newObj->updated_by = auth()->user()->id;
                        $newObj->save();
                    } else {
                        $matchThese = ['lab_invoice_id' => $obj->id, 'investigation_id' => $investigation];
                        LabInvoiceItem::updateOrCreate($matchThese, ['price' => $price, 'investigation_price_id' => $priceObj->id, 'created_by' => auth()->user()->id]);
                    }

                    $total_amount = $total_amount + $price;
                    $total_investigation_items++;
                }
            }
        }

        $obj->total_amount = $total_amount;
        $discount_amount = ($obj->discount_percentage/100)*$total_amount;
        $obj->net_amount = $total_amount - $discount_amount;
        $obj->amount_received = $obj->net_amount;
        $obj->discount_amount = $discount_amount;
        $obj->receipt_number = intval($obj->id) + 1000;
        $obj->invoice_sequence = generateLabSequenceInvoice($obj->receipt_number);
        $obj->update();

        if ($total_investigation_items < 6) {
            $filldata_investigations = 6 - $total_investigation_items;
        }

        return $this->generatePDF($filldata_investigations, $obj, $patient, $total_investigation_items, $hospital);
    }

    public static function getLabGroupTestsDir()
    {
        return 'assets/lab_groups/';
    }

    public function generatePDF($filldata_investigations, $obj, $patient, $total_investigation_items, $hospital)
    {
        $hospital = Hospital::where('id', $hospital->id)->first();
        $invoice_items = LabInvoiceItem::getInvoiceItems($obj->id);

        $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        ->loadView('documents.receipts.lab_reciept', ['invoice_items' => $invoice_items, 'invoice' => $obj, 'hospital'=> $hospital,'patient'=> $patient])
         ->setPaper([0, 0, 244, 500], 'portrait');

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


    public static function getDailyInvoiceStatsData()
    {

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $date = Carbon::now()->format('Y-m-d');
        $invoices = self::leftjoin('patients as p', 'p.id', 'lab_invoices.patient_id')
            ->select(
                'p.name_of_patient',
                'p.patient_mr_number',
                'lab_invoices.date_issued',
                'lab_invoices.total_amount',
                'lab_invoices.discount_amount',
                'lab_invoices.net_amount',
                'lab_invoices.amount_received'
            )
            ->whereDate('lab_invoices.created_at', Carbon::parse($date))
            ->where('lab_invoices.hospital_id', '=', $hospital_id)
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
        $invoices = self::leftjoin('patients as p', 'p.id', 'lab_invoices.patient_id')
            ->select(
                'p.name_of_patient',
                'p.patient_mr_number',
                'lab_invoices.date_issued',
                'lab_invoices.total_amount',
                'lab_invoices.discount_amount',
                'lab_invoices.net_amount',
                'lab_invoices.amount_received'
            )
            ->where('lab_invoices.created_at', '>=', $date)
            ->where('lab_invoices.hospital_id', '=', $hospital_id)
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

        return self::where('lab_invoices.hospital_id', '=', $hospital_id)
            ->count();
    }

    public static function getMonthlyInvoiceStatsData()
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];
        $date = Carbon::today()->subDays(30);
        $invoices = self::leftjoin('patients as p', 'p.id', 'lab_invoices.patient_id')
            ->select(
                'p.name_of_patient',
                'p.patient_mr_number',
                'lab_invoices.date_issued',
                'lab_invoices.total_amount',
                'lab_invoices.discount_amount',
                'lab_invoices.net_amount',
                'lab_invoices.amount_received'
            )
            ->where('lab_invoices.created_at', '>=', $date)
            ->where('lab_invoices.hospital_id', '=', $hospital_id)
            ->get();

        $data['count'] = count($invoices);
        $data['total_amount'] = $invoices->sum('total_amount');
        $data['received_amount'] = $invoices->sum('amount_received');
        $data['discount_amount'] = $invoices->sum('discount_amount');

        return $data;
    }

}
