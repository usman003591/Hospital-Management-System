<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientEmergencyContact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'patient_emergency_contacts';

    protected $fillable = ['patient_id', 'name', 'relation', 'contact'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->created_by && auth()->check()) {
                $model->created_by = auth()->id();
            }
        });
    }
}
