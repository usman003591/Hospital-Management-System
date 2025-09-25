<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceVerificationAuditLog extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'finance_verification_audit_logs';

    protected $fillable = [
        'verifiable_type',
        'verifiable_type_id',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at',
        'remarks',
        'ip_address',
        'meta',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getLogsByInvoiceId($invoiceId, $type)
    {
        return self::leftJoin('users', 'finance_verification_audit_logs.changed_by', '=', 'users.id')
            ->where('verifiable_type', $type)
            ->where('verifiable_type_id', $invoiceId)
            ->orderBy('created_at', 'desc')
            ->get(['finance_verification_audit_logs.*', 'users.name as changed_by_name']);
    }

    public static function createAuditLog ($data) {

        $obj = new self;
        $obj->fill($data);
        $obj->save();

        return $obj;
    }


}
