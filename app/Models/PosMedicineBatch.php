<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosMedicineBatch extends Model
{
    protected $fillable = [
        'medicine_batch_number',
        'batch_number',
        'expiry_date',
        'manufacturing_date',
        'quantity',
        'medicine_minimum_quantity',
        'packet_price',
        'packet_items',
        'barcode',
        'selling_price',
        'created_by',
        'updated_by',
    ];
}
