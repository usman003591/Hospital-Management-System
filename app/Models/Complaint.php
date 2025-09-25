<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'description', 'parent_id', 'created_by', 'updated_by', 'verification_status', 'is_manual', 'approved_by', 'rejected_by',];

    //Relationships
    public function cdComplaints()
    {
        return $this->hasMany(CdComplaint::class, 'complaint_id');
    }

    public function cdComplaintDetails()
    {
        return $this->hasMany(CdComplaintDetail::class, 'complaint_id');
    }


    //Static methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getParentComplaints()
    {
        return self::where('parent_id', 0)->get();
    }

    public static function getAllChildComplaints()
    {
        return self::where('parent_id', '!=', 0)->where('verification_status', '!=', 'rejected')->get();
    }

    public static function getAll()
    {
        $request = request();

        $search = [
            'q' => $request->input('q'),
            'parent_id' => $request->input('parent_id'),
            'verification_status' => $request->input('verification_status'),
        ];


        $query = \DB::table('complaints as c')
            ->leftjoin('complaints as complaint', 'c.parent_id', '=', 'complaint.id')
            ->select([
                'c.*',
                'complaint.name as parent_name',
                'complaint.id as parent_id'
            ])->whereNotNull('c.id')
            ->whereNull('c.deleted_at');
        ;

        if (!empty($search['q'])) {
            $query->where('c.name', 'ILIKE', '%' . $search['q'] . '%');
        }

        if (!is_null($search['parent_id'])) {
            if ($search['parent_id'] === '0' || $search['parent_id'] === 0) {
                $query->where('c.parent_id', 0);
            } else {
                $query->where('c.parent_id', $search['parent_id']);
            }
        }

        if (!is_null($search['verification_status'])) {
            $query->where('c.verification_status', $search['verification_status']);
        }

        $results = $query->orderByDesc('c.created_at')->paginate(10);

        return [
            'search' => $search,
            'data' => $results,
            'verification_status' => $search['verification_status']
        ];
    }

    public function addForm()
    {
        // if ($request === false) {
        //     $request = request();
        // }


        request()->validate([
            'name' => ['required', 'string', 'unique:complaints,name'],
            'description' => ['required', 'string', 'max:250']
        ], [
            'name.required' => 'Name is required',
            'description.required' => 'The description is required',
        ]);

        $complaint = Complaint::create([
            'name' => request('name'),
            'description' => request('description'),
            'created_by' => auth()->user()->id
        ]);

        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $complaint->parent_id = request('parent_id');
            $complaint->update();
        }
        // $obj = new Complaint;
        // $obj->name = ->name;
        // $obj->status = 1;
        // $obj->created_by = auth()->user()->id;
        // $obj->save();

        session()->flash('success', 'Complaint created successfully');
        return Redirect::route('complaints.index');
    }

    public function updateForm($id)
    {
        // if ($request === false) {
        //     $request = request();
        // }

        request()->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ], [
            'name.required' => 'Name is required',
            'description.required' => 'The description is required',
        ]);

        $obj = Complaint::find($id);
        $obj->update([
            'name' => request('name'),
            'description' => request('description'),
            'updated_by' => auth()->user()->id
        ]);


        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $obj->parent_id = request('parent_id');
            $obj->update();
        }

        session()->flash('success', 'Complaint updated successfully');
        return Redirect::route('complaints.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Complaint has been deleted successfully',
        ]);
    }
}
