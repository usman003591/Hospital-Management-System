<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Redirect;

class CdComplaintDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cd_complaint_id', 'complaint_id', 'created_by', 'updated_by', 'deleted_by'];

    // Relationships
    public function cdComplaint()
    {
        return $this->belongsTo(CdComplaint::class, 'cd_complaint_id');
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }

    // Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('cd_complaint_details.id', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('cd_complaint_details.id')
            ->whereNull('cd_complaint_details.deleted_at')
            ->latest()
            ->paginate(10);

        return $rtn;
    }



    public function addForm()
    {
        request()->validate([
            'cd_complaint_id' => ['required', 'exists:cd_complaints,id'],
            'complaint_id' => ['required', 'exists:complaints,id']
        ]);

        $obj = CdComplaintDetail::create([
            'cd_complaint_id' => request('cd_complaint_id'),
            'complaint_id' => request('complaint_id'),
            'created_by' => auth()->user()->id
        ]);

        session()->flash('success', 'Complaint detail added successfully');
        return Redirect::route('cd_complaint_details.index');
    }

    public function updateForm($id)
    {
        request()->validate([
            'cd_complaint_id' => ['required', 'exists:cd_complaints,id'],
            'complaint_id' => ['required', 'exists:complaints,id']
        ]);

        $obj = CdComplaintDetail::find($id);
        $obj->update([
            'cd_complaint_id' => request('cd_complaint_id'),
            'complaint_id' => request('complaint_id'),
            'updated_by' => auth()->user()->id
        ]);

        session()->flash('success', 'Complaint detail updated successfully');
        return Redirect::route('cd_complaint_details.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Complaint detail deleted successfully',
        ]);
    }
}
