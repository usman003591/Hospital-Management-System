<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabInvestigationPrice extends Model
{
     use HasFactory;
     use SoftDeletes;

    protected $fillable = [
        'investigation_id',
        'price',
        'valid_from',
        'valid_to',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getInvestigationPrice($investigation_id) {
        return self::where('investigation_id', $investigation_id)->first();
    }

    public static function createInvestigationPrice ($data) {

        $matchThese = [
            'investigation_id'=>$data['investigation_id'],
            'valid_from'=>$data['valid_from'],
            'valid_to'=>$data['valid_to'],
        ];
        $labInvestigationPrice = self::updateOrCreate($matchThese,[
            'price'=>$data['price'],
            'created_by'=> auth()->user()->id
        ]);

        return $labInvestigationPrice;
    }
}
