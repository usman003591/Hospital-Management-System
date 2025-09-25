<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rooms';

    protected $fillable = [
        'ward_id',
        'room_number',
        'room_description',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['ward'] = $request->has('ward') ? $request->get('ward') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;


        $data = self::leftJoin('wards as w', 'w.id', '=', 'rooms.ward_id')
            ->select([
                'rooms.*',
                'w.ward_name as ward_name',
            ]);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('rooms.room_number', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('rooms.room_description', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('w.ward_name', 'iLIKE', "%{$search['q']}%");
            });
        }
        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('rooms.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('rooms.status', 0);
            }
        }
        if ($search['ward']) {
            $data = $data->where('rooms.ward_id', $search['ward']);
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

        $ward = $request->ward_id;
        request()->validate([
            'ward_id' => ['required'],
            'room_number' => ['required', 'integer', Rule::unique('rooms')->where(fn (Builder $query) => $query->where('ward_id', $ward))->withoutTrashed()],
            'room_description' => ['required', 'string'],
        ], [
            'ward_id.required' => 'Ward is required',
            'room_number.required' => 'Room number is required',
            'room_number.unique' => 'Room number already exists in this ward',
            'room_number.integer' => 'Room number must be an integer',
            'room_description.required' => 'Room description is required',
        ]);


        $obj = new Room;
        $obj->ward_id = $ward;
        $obj->room_number = $request->room_number;
        $obj->room_description = $request->room_description;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Room added successfully');
        return redirect()->route('rooms.index');
    }

    public function updateForm(Request $request)
{
    $room = Room::findOrFail($request->id); // use fail-safe method
    $wardId = $request->ward_id;

    $validatedData = $request->validate([
        'ward_id' => ['required'],
        'room_number' => [
            'required',
            'integer',
            Rule::unique('rooms')
                ->where(fn (Builder $query) => $query->where('ward_id', $wardId))
                ->ignore($room->id)
                ->withoutTrashed()
        ],
        'room_description' => ['required', 'string'],
        'status' => ['required', 'integer'],
    ], [
        'ward_id.required' => 'Ward is required',
        'room_number.required' => 'Room number is required',
        'room_number.unique' => 'Room number already exists in this ward',
        'room_number.integer' => 'Room number must be an integer',
        'room_description.required' => 'Room description is required',
        'status.required' => 'Status is required',
    ]);

    // Assign validated data
    $room->ward_id = $wardId;
    $room->room_number = $request->room_number;
    $room->room_description = $request->room_description;
    $room->status = $request->status;
    $room->updated_by = auth()->id();
    $room->save();

    session()->flash('success', 'Room updated successfully.');
    return redirect()->route('rooms.index');
}

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Room has been deleted successfully',
        ]);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }

    public function beds()
    {
        return $this->hasMany(Bed::class, 'room_id', 'id');
    }
}
