<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PosInvocie extends Model
{
     use SoftDeletes, HasFactory;

    public $table = 'pos_invoices';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'invoice_number',
        'dateIssued',
        'order_id',
        'discount_percentage',
        'final_amount',
        'invoice_file_name',
        'invoice_file_path',
        'hospital_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getInvoicesDir()
    {
        return 'assets/invoices/';
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

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

        public static function getDailyInvoiceStatsData()
    {

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $date = Carbon::now()->format('Y-m-d');
        $invoices = self::select(
                'pos_invoices.*',
            )
            ->whereDate('pos_invoices.created_at', Carbon::parse($date))
            ->where('pos_invoices.hospital_id', '=', $hospital_id)
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
        $invoices = self::select(
                'pos_invoices.*',
            )
            ->where('pos_invoices.created_at', '>=', $date)
            ->where('pos_invoices.hospital_id', '=', $hospital_id)
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

        return self::where('pos_invoices.hospital_id', '=', $hospital_id)
            ->count();
    }

    public static function getMonthlyInvoiceStatsData()
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];
        $date = Carbon::today()->subDays(30);
        $invoices = self::select(
                'pos_invoices.*',
            )
            ->where('pos_invoices.created_at', '>=', $date)
            ->where('pos_invoices.hospital_id', '=', $hospital_id)
            ->get();

        $data['count'] = count($invoices);
        $data['total_amount'] = $invoices->sum('total_amount');
        $data['received_amount'] = $invoices->sum('amount_received');
        $data['discount_amount'] = $invoices->sum('discount_amount');

        return $data;
    }


}
