<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdSystematicPhysicalExaminationDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'cd_systematic_physical_examination_id',
        'spe_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function systematicPhysicalExamination()
    {
        return $this->belongsTo(CdSystematicPhysicalExamination::class, 'cd_systematic_physical_examination_id');
    }

    public function spe()
    {
        return $this->belongsTo(SystematicPhysicalExamination::class);
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
            $data = $data->where('cd_systematic_physical_examination_id',$search['q']);
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
            'cd_systematic_physical_examination_id' => ['required'],
            'spe_id' => ['required'],
        ]);

        $obj = new CdSystematicPhysicalExaminationDetail;
        $obj->cd_systematic_physical_examination_id = $request->cd_systematic_physical_examination_id;
        $obj->spe_id = $request->spe_id;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Cd Systematic Physical Examination Detail created successfully');
        return Redirect::route('cd_systematic_physical_examination_details.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = CdSystematicPhysicalExaminationDetail::find($request->id);

        $request->validate([
            'cd_systematic_physical_examination_id' => ['required'],
            'spe_id' => ['required'],
        ]);

        $obj->cd_systematic_physical_examination_id = $request->cd_systematic_physical_examination_id;
        $obj->spe_id = $request->spe_id;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Cd Systematic Physical Examination Detail updated successfully');
        return Redirect::route('cd_systematic_physical_examination_details.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Cd Systematic Physical Examination Detail has been deleted successfully',
        ]);
    }
}
