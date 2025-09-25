<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Floor extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'floors';

    protected $fillable = [
        'floor_name', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];
    
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveDepartments()
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
            $data = $data->where('floor_name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('floors.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('floors.status', 0);
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
            'floor_name' => ['required']
        ]);

        $obj = new Floor;
        $obj->floor_name = $request->floor_name;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Floor created successfully');
        return Redirect::route('floors.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = Floor::find($request->id);

        $request->validate([
            'floor_name' => ['required'],
            'status' => ['required'],
        ]);

        $obj->floor_name = $request->floor_name;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Floor updated successfully');
        return Redirect::route('floors.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Floor has been deleted successfully',
        ]);
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'ward_id', 'id');
    }
}
