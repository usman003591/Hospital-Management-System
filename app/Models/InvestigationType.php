<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestigationType extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }


    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        // $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('name', 'iLIKE', "%{$search['q']}%");
        }



        $rtn['search'] = $search;
        $rtn['data'] = $data->orderBy('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public static function getActiveInvestigationTypes()
    {
        return self::get();
    }

    public function addForm()
    {
        request()->validate([
            'name' => ['required', 'string'],
        ]);

       InvestigationType::create([
            'name' => request('name'),
            'created_by' => auth()->user()->id
        ]);

        session()->flash('success', 'Investigation type created successfully');
        return Redirect::route('investigation_types.index');
    }

    public function updateForm($id)
    {
        request()->validate([
            'name' => ['required', 'string'],
        ]);

        $obj =InvestigationType::find($id);
        $obj->update([
            'name' => request('name'),
            'updated_by' => auth()->user()->id
        ]);

        session()->flash('success', 'Investigation Type updated successfully');
        return Redirect::route('investigation_types.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Investigation Type has been deleted successfully',
        ]);
    }
}
