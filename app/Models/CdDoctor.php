<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Redirect;

class CdDoctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cd_id', 'doctor_id', 'start_date', 'end_date', 'created_by', 'updated_by', 'deleted_by'];

    // Relationships
    public function clinicalDiagnosis()
    {
        return $this->belongsTo(ClinicalDiagnosis::class, 'cd_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
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
            $data = $data->where('cd_doctors.start_date', 'iLIKE', "%{$search['q']}%")
                ->orWhere('cd_doctors.end_date', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('cd_doctors.id')
            ->whereNull('cd_doctors.deleted_at')
            ->latest()
            ->paginate(10);

        return $rtn;
    }

    public function addForm()
    {
        request()->validate([
            'cd_id' => ['required', 'exists:clinical_diagnoses,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date']
        ]);

        $obj = CdDoctor::create([
            'cd_id' => request('cd_id'),
            'doctor_id' => request('doctor_id'),
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
            'created_by' => auth()->user()->id
        ]);

        session()->flash('success', 'Doctor assigned to clinical diagnosis successfully');
        return Redirect::route('cd_doctors.index');
    }

    public function updateForm($id)
    {
        request()->validate([
            'cd_id' => ['required', 'exists:clinical_diagnoses,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date']
        ]);

        $obj = CdDoctor::find($id);
        $obj->update([
            'cd_id' => request('cd_id'),
            'doctor_id' => request('doctor_id'),
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
            'updated_by' => auth()->user()->id
        ]);

        session()->flash('success', 'Doctor assignment updated successfully');
        return Redirect::route('cd_doctors.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Doctor assignment removed successfully',
        ]);
    }
}
