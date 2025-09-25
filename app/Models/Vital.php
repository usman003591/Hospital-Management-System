<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vital extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'status', 'unit', 'is_boolean', 'created_by', 'updated_by'];

    //Relationships
    public function cdVitals()
    {
        return $this->hasMany(CdVital::class, 'vital_id');
    }

    //Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveVitals()
    {
        return self::select('*')->where('status', 1)->orderBy('id', 'asc')->get();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;
        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('vitals.name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('vitals.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('vitals.status', 0);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('vitals.id')
            ->whereNull('vitals.deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $rtn;
    }

    public function addForm()
    {
        request()->validate([
            'name' => ['required', 'string'],
            'unit' => ['required'],
            'is_boolean' => ['required']
        ]);

        $obj = Vital::create([
            'name' => request('name'),
            'status' => 1,
            'unit' => request('unit'),
            'is_boolean' => request('is_boolean'),
            'created_by' => auth()->user()->id
        ]);

        session()->flash('success', 'Vital created successfully');
        return Redirect::route('vitals.index');
    }

    public function updateForm($id)
    {
        request()->validate([
            'name' => ['required', 'string'],
            'unit' => ['required'],
            'is_boolean' => ['required'],
        ]);

        $obj = Vital::find($id);
        $obj->update([
            'name' => request('name'),
            'status' => request('status'),
            'unit' => request('unit'),
            'is_boolean' => request('is_boolean'),
            'updated_by' => auth()->user()->id
        ]);

        session()->flash('success', 'Vital updated successfully');
        return Redirect::route('vitals.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Vital has been deleted successfully',
        ]);
    }
}
