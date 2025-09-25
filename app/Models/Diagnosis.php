<?php

namespace App\Models;

use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnosis extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'diagnosis';

    protected $fillable = ['name', 'code', 'status', 'created_by', 'updated_by', 'verification_status', 'is_manual', 'approved_by', 'rejected_by'];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getDiagnosisBasedOnSearach ($search) {

        $data = Diagnosis::select("name", "id", "code")
        ->where('name', 'LIKE', '%'. $search. '%')
        ->where('status',1)->where('verification_status', '!=', 'rejected')
        ->get();

        return response()->json($data);
    }

    public static function getActiveDiagnosis()
    {
        return self::where('status', 1)->where('verification_status', '!=', 'rejected')->get();
    }

    // public static function getParentDiagnosis()
    // {
    //     return self::where('parent_id', 0)->get();
    // }

    // public static function getAllChilDiagnosis()
    // {
    //     return self::where('parent_id', '!=', 0)->where('verification_status', '!=', 'rejected')->get();
    // }

    public static function getAll()
    {
        $request = request();

        $search = [
            'q' => $request->get('q', ''),
            'status' => $request->get('status', null),
            'verification_status' => $request->get('verification_status', null),
        ];

        $query = self::query();

        if (!empty($search['q'])) {
            $query->where('name', 'ILIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== null) {
            $query->where('status', $search['status']);
        }
        if ($search['verification_status'] !== null) {
            $query->where('verification_status', $search['verification_status']);
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return ['search' => $search, 'data' => $data, 'verification_status' => $search['verification_status']];
    }

    public function addForm()
    {
        // if ($request === false) {
        //     $request = request();
        // }

        request()->validate([
            'name' => ['required', 'string', Rule::unique('diagnosis', 'name')->whereNull('deleted_at')],
        ]);

        $diagnosis = Diagnosis::create([
            'name' => request('name'),
            'status' => 1,
            'created_by' => auth()->user()->id
        ]);

        // $this->name = $request->name;
        // $this->status = 1;
        // $this->created_by = auth()->user()->id;
        // $this->save();

        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $diagnosis->parent_id = request('parent_id');
            $diagnosis->update();
        }

        session()->flash('success', 'Diagnosis created successfully');
        return Redirect::route('diagnosis.index');
    }

    public function updateForm($id)
    {
        // if ($request === false) {
        //     $request = request();
        // }

        request()->validate([
            'name' => ['required', 'string', Rule::unique('diagnosis', 'name')->ignore($this->id)->whereNull('deleted_at')],
        ]);

        $obj = Diagnosis::find($id);
        $obj->update([
            'name' => request('name'),
            'status' => request('status'),
            'updated_by' => auth()->user()->id
        ]);

        // $this->name = $request->name;
        // $this->status = $request->status;
        // $this->updated_by = auth()->user()->id;
        // $this->update();

        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $obj->parent_id = request('parent_id');
            $obj->update();
        }

        session()->flash('success', 'Diagnosis updated successfully');
        return Redirect::route('diagnosis.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Diagnosis deleted successfully',
        ]);
    }
}
