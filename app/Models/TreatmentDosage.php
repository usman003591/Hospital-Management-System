<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreatmentDosage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'name_ur', 'status', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 'treatment_dosage';

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveTreatmentDosages()
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
                $data = $data->where('treatment_dosage.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('treatment_dosage.status', 0);
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
            'name' => ['required', Rule::unique('treatment_dosage', 'name')->whereNull('deleted_at')],
            'name_ur' => ['required', Rule::unique('treatment_dosage', 'name_ur')->whereNull('deleted_at')]
        ],[
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'name_ur.required' => 'Name in urdu is required',
            'name_ur.unique' => 'Name in urdu already exists',
        ]);

        $obj = new TreatmentDosage;
        $obj->name = $request->name;
        $obj->name_ur = $request->name_ur;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Medication Quantity created successfully');
        return Redirect::route('treatment_dosage.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = TreatmentDosage::find($request->id);

        $request->validate([
            'name' => ['required', Rule::unique('treatment_dosage', 'name')->ignore($obj->id)->whereNull('deleted_at')],
            'name_ur' => ['required', Rule::unique('treatment_dosage', 'name_ur')->ignore($obj->id)->whereNull('deleted_at')],
            'status' => ['required'],
        ],[
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'name_ur.required' => 'Name in urdu is required',
            'name_ur.unique' => 'Name in urdu already exists'
        ]);

        $obj->name = $request->name;
        $obj->name_ur = $request->name_ur;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Medication Quantity updated successfully');
        return Redirect::route('treatment_dosage.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Medication Quantity has been deleted successfully',
        ]);
    }
}
