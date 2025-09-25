<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdDiagnosisDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cd_diagnosis_id',
        'diagnosis_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function cdDiagnosis()
    {
        return $this->belongsTo(CdDiagnosis::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('cd_diagnosis_id', $search['q']);
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'cd_diagnosis_id' => ['required'],
            'diagnosis_id' => ['required'],
        ]);

        $obj = new CdDiagnosisDetail;
        $obj->cd_diagnosis_id = $request->cd_diagnosis_id;
        $obj->diagnosis_id = $request->diagnosis_id;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Cd Diagnosis Detail created successfully');
        return Redirect::route('cd_diagnosis_details.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = CdDiagnosisDetail::find($request->id);

        $request->validate([
            'cd_diagnosis_id' => ['required'],
            'diagnosis_id' => ['required'],
        ]);

        $obj->cd_diagnosis_id = $request->cd_diagnosis_id;
        $obj->diagnosis_id = $request->diagnosis_id;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Cd Diagnosis Detail updated successfully');
        return Redirect::route('cd_diagnosis_details.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Cd Diagnosis Detail has been deleted successfully',
        ]);
    }
}
