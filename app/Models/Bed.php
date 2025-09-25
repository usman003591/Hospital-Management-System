<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bed extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'beds';
    protected $fillable = [
        'room_id',
        'ward_id',
        'bed_number',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function getAll()
{
    $request = request();

    $search['q'] = $request->has('q') ? $request->get('q') : false;
    $search['room'] = $request->has('room') && $request->get('room') !== '' ? $request->get('room') : false;
    $search['status'] = $request->has('status') ? $request->get('status') : false; // Default to 'All'

    $data = self::leftJoin('rooms as r', 'r.id', '=', 'beds.room_id')
        ->select([
            'beds.*',
            'r.room_number as room_name',
        ]);

    if ($search['q']) {
        $data = $data->where(function ($query) use ($search) {
            $query->where('r.room_number', 'iLIKE', "%{$search['q']}%")
                ->orWhere('beds.bed_number', 'iLIKE', "%{$search['q']}%");
        });
    }

    if ($search['room']) {
        $data = $data->where('beds.room_id', $search['room']);
    }

    // Handle status filter properly
    if ($search['status'] !== false) {
        if ($search['status'] == 1) {
            $data = $data->where('beds.status', 1);
        } elseif ($search['status'] == 0) {
            $data = $data->where('beds.status', 0);
        }
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
            'room_id' => ['required'],
            'ward_id' => ['required'],
            'bed_number' => ['required', 'integer'],
        ], [
            'room_id.required' => 'Room is required',
            'ward_id.required' => 'Ward is required',
            'bed_number.required' => 'Bed number is required',
        ]);

        $obj = new Bed;
        $obj->room_id = $request->room_id;
        $obj->ward_id = $request->ward_id;
        $obj->bed_number = $request->bed_number;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Bed added successfully');
        return redirect()->route('beds.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = Bed::find($request->id);
        request()->validate([
            'room_id' => ['required'],
            'ward_id' => ['required'],
            'bed_number' => ['required', 'integer'],
            'status' => ['required', 'integer'],
        ], [
            'room_id.required' => 'Room is required',
            'ward_id.required' => 'Ward is required',
            'bed_number.required' => 'Bed number is required',
            'status.required' => 'Status is required',
        ]);

        $obj->room_id = $request->room_id;
        $obj->ward_id = $request->ward_id;
        $obj->bed_number = $request->bed_number;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Bed updated successfully');
        return redirect()->route('beds.index');
    }
    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Bed has been deleted successfully',
        ]);
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }
}
