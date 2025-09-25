<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiagnosisCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'diagnosis_categories';

    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveDiagnosisCategories()
    {
        return self::where('status', 1)->get();
    }
}
