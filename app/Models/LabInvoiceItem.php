<?php

namespace App\Models;

use Response;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\LabInvoice;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Jobs\GenerateInvoice;
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

class LabInvoiceItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'lab_invoice_items';

    protected $fillable = [
        'lab_invoice_id',
        'investigation_id',
        'investigation_price_id',
        'price',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getInvoiceItems($invoiceId)
    {
        return self::join('lab_investigation_prices', 'lab_invoice_items.investigation_price_id', '=', 'lab_investigation_prices.id')
            ->join('investigations', 'lab_invoice_items.investigation_id', '=', 'investigations.id')
            ->where('lab_invoice_id', $invoiceId)
            ->select('lab_invoice_items.*', 'investigations.name as investigation_name')
            ->get();
    }

    public static function getInvoiceInvestigations($invoiceId) {
        return self::join('lab_investigation_prices', 'lab_invoice_items.investigation_price_id', '=', 'lab_investigation_prices.id')
            ->join('investigations', 'lab_invoice_items.investigation_id', '=', 'investigations.id')
            ->where('lab_invoice_id', $invoiceId)
            ->select('lab_invoice_items.*', 'investigations.name as investigation_name')
            ->get();
    }

}
