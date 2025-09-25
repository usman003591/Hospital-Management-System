<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreatmentDoseInterval extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'status', 'name_ur', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 'treatment_dose_interval';


    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveTreatmentDoseIntervals()
    {
        return self::where('status', 1)->get();
    }

    public static function getForSelect()
    {
        return self::get();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('treatment_dose_interval.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('treatment_dose_interval.status', 0);
            }
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
            'name' => ['required', Rule::unique('treatment_dose_interval', 'name')->whereNull('deleted_at')],
            'name_ur' => ['required', Rule::unique('treatment_dose_interval', 'name_ur')->whereNull('deleted_at')],
        ],[
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'name_ur.required' => 'Name in urdu is required',
            'name_ur.unique' => 'Name in urdu already exists',
        ]);

        $obj = new TreatmentDoseInterval;
        $obj->name = $request->name;
        $obj->name_ur = $request->name_ur;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Medication dose interval created successfully');
        return Redirect::route('treatment_dose_interval.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = TreatmentDoseInterval::find($request->id);

        $request->validate([
            'name' => ['required', Rule::unique('treatment_dose_interval', 'name')->ignore($obj->id)->whereNull('deleted_at')],
            'name_ur' => ['required', Rule::unique('treatment_dose_interval', 'name_ur')->ignore($obj->id)->whereNull('deleted_at')],
            'status' => ['required'],
        ],[
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'name_ur.required' => 'Name in urdu is required',
            'name_ur.unique' => 'Name in urdu already exists',
        ]);

        $obj->name = $request->name;
        $obj->name_ur = $request->name_ur;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Medication dose interval updated successfully');
        return Redirect::route('treatment_dose_interval.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Medication dose interval has been deleted successfully',
        ]);
    }
}
