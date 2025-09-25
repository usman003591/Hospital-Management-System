<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientsBriefHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'description',
        'clinical_diagnosis_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
