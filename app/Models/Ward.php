<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wards';

    protected $fillable = [
        'floor_id',
        'ward_name',
        'ward_description',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['floor'] = $request->has('floor') ? $request->get('floor') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;


        $data = self::leftJoin('floors as f', 'f.id', '=', 'wards.floor_id')
        ->select([
            'wards.*',
            'f.floor_name as floor_name',
        ]);

        if ($search['q']) {
            $data = $data->where('wards.ward_name', 'iLIKE', "%{$search['q']}%")
                ->orWhere('wards.ward_description', 'iLIKE', "%{$search['q']}%")
                ->orWhere('f.floor_name', 'iLIKE', "%{$search['q']}%");;
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('wards.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('wards.status', 0);
            }
        }
        if ($search['floor']) {
            $data = $data->where('wards.floor_id', $search['floor']);
        }
        $rtn['search'] = $search;
        $rtn['data'] = $data->latest()->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {

        if ($request === false) {
            $request = request();
        }
        request()->validate([
            'floor_id' => ['required'],
            'ward_name' => ['required', 'string'],
            'ward_description' => ['required', 'string'],
        ], [
            'floor_id.required' => 'Please select floor',
            'ward_name.required' => 'Ward name is required',
            'ward_description.required' => 'Ward description is required',
        ]);

        $obj = new Ward;
        $obj->floor_id = $request->floor_id;
        $obj->ward_name = $request->ward_name;
        $obj->ward_description = $request->ward_description;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Ward added successfully');
        return redirect()->route('wards.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = Ward::find($request->id);
        request()->validate([
            'floor_id' => ['required'],
            'ward_name' => ['required', 'string'],
            'ward_description' => ['required', 'string'],
            'status' => ['required', 'integer'],
        ], [
            'floor_id.required' => 'Please select floor',
            'ward_name.required' => 'Ward name is required',
            'ward_description.required' => 'Ward description is required',
            'status.required' => 'Status is required',
        ]);

        $obj->floor_id = $request->floor_id;
        $obj->ward_name = $request->ward_name;
        $obj->ward_description = $request->ward_description;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Ward updated successfully');
        return redirect()->route('wards.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Ward has been deleted successfully',
        ]);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }
    public function rooms()
    {
        return $this->hasMany(Room::class, 'ward_id', 'id');
    }
}
