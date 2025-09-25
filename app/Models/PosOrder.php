<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosOrder extends Model
{
      use SoftDeletes, HasFactory;

    public $table = 'pos_orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'order_number',
        'order_date',
        'total_amount',
        'total_items',
        'cashier_id',
        'patient_id',
        'payment_method_id',
        'order_status_id',
        'hospital_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
