<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Redirect;

class OPDCounter extends Model
{
    use HasFactory, SoftDeletes;

   
    protected $table = 'o_p_d_counters';

    protected $fillable = [
        'name', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveCounters()
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
                $data = $data->where('o_p_d_counters.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('o_p_d_counters.status', 0);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderBy('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
            $validated = $request->validate([
            'name' => 'required|max:50|unique:o_p_d_counters,name'  
        ]);
    
        
            $obj = new OPDCounter();
            $obj->name = $validated['name']; 
            $obj->status = 1;
            $obj->created_by = auth()->id();  
            $obj->save();
    
            return redirect()
                  ->route('opd_counter.index')
                  ->with('success', 'OPD Counter created successfully');
                  
       
    }
    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $obj = OPDCounter::find($request->id);

        $request->validate([
            'name' => ['required'],
            'status' => ['required'],
        ]);

        $obj->name = $request->name;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'OPD Counter updated successfully');
        return Redirect::route('opd_counter.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'OPD Counter has been deleted successfully',
        ]);
    }
}