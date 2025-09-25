<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;


class MedicineDuration extends Model
{
    protected $fillable = ['name', 'name_ur', 'status', 'created_by', 'updated_by', 'deleted_by'];

    public static function getActiveDuration()
    {
        return self::where('status', 1)->get();
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
                $data = $data->where('medicine_durations.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('medicine_durations.status', 0);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100', 'string'],
            'name_ur' => ['nullable', 'string']
        ], [
            'name.required' => 'Medication duration name is required',
            'name.max' => 'Medication duration name should not be more than 100 characters',
            'name.string' => 'Medication duration name should be a string',
            'name_ur.string' => 'Medication duration name in urdu should be a string'
        ]);

        MedicineDuration::create([
            'name' => $request->name,
            'name_ur' => $request->name_ur,
            'status' => 1,
            'created_by' => auth()->user()->id,
        ]);

        session()->flash('success', 'Medication Duration created successfully');
        return Redirect::route('medicine_durations.index');
    }

    public function updateForm($id)
    {
        $request = request();
        $request->validate([
            'name' => ['required', 'max:100', 'string'],
            'name_ur' => ['nullable', 'string'],
            'status' => ['required']
        ],[
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'name_ur.required' => 'Name in urdu is required',
            'name_ur.unique' => 'Name in urdu already exists',
            'status.required' => 'Status is required'
        ]);

        MedicineDuration::find($id)->update([
            'name' => $request->name,
            'name_ur' => $request->name_ur,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);

        session()->flash('success', 'Medication duration updated successfully');
        return Redirect::route('medicine_durations.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Medication duration has been deleted successfully',
        ]);
    }
}
