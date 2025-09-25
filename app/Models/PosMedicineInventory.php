<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosMedicineInventory extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'pos_medicine_inventory';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'medicine_id',
        'hospital_id',
        'quantity',
        'reorder_number',
        'medicine_inventory_status_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Pos Medicine inventory has been deleted successfully',
        ]);
    }


}
