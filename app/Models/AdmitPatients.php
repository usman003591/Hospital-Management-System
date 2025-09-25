<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdmitPatients extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'admit_patients';

    protected $fillable = [
        'ward_id',
        'room_id',
        'bed_id',
        'department_id',
        'admission_date',
        'remarks',
        'discharge_date',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'admission_date' => 'datetime',
        'discharge_date' => 'datetime'
    ];

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['ward'] = $request->has('ward') ? $request->get('ward') : false;
        $search['department'] = $request->has('department') ? $request->get('department') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;


        $data = self::leftJoin('wards as w', 'w.id', '=', 'admit_patients.ward_id')
            ->leftJoin('rooms as r', 'r.id', '=', 'admit_patients.room_id')
            ->leftJoin('beds as b', 'b.id', '=', 'admit_patients.bed_id')
            ->leftJoin('departments as d', 'd.id', '=', 'admit_patients.department_id')
            ->select([
                'admit_patients.*',
                'w.ward_name as ward_name',
                'r.room_number',
                'b.bed_number',
                'd.name as department_name'
            ]);

        if ($search['q']) {
            $data = $data->where(function($query) use ($search) {
                $query->where('w.ward_name', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('r.room_number', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('b.bed_number', 'iLIKE', "%{$search['q']}%");
            });
        }

        if ($search['ward']) {
            $data = $data->where('admit_patients.ward_id', $search['ward']);
        }

        if ($search['department']) {
            $data = $data->where('admit_patients.department_id', $search['department']);
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('admit_patients.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('admit_patients.status', 0);
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
            'ward_id' => ['required'],
            'room_id' => ['required'],
            'bed_id' => ['required'],
            'department_id' => ['required'],
            'admission_date' => ['required', 'date_format:d/m/Y H:i'],
            'discharge_date' => ['nullable', 'date_format:d/m/Y H:i'],
        ], [
            'ward_id.required' => 'Ward is required',
            'room_id.required' => 'Room is required',
            'bed_id.required' => 'Bed is required',
            'department_id.required' => 'Department is required',
            'admission_date.required' => 'Admission date is required',
            'admission_date.date_format' => 'Admission date must be in correct format (DD/MM/YYYY HH:mm)',
            'discharge_date.date_format' => 'Discharge date must be in correct format (DD/MM/YYYY HH:mm)',
        ]);
        $admissionDate = Carbon::createFromFormat('d/m/Y H:i', request('admission_date'))->format('Y-m-d H:i');
        $dischargeDate = request('discharge_date') ? Carbon::createFromFormat('d/m/Y H:i', request('discharge_date'))->format('Y-m-d H:i') : null;

        $obj = new AdmitPatients;
        $obj->ward_id = $request->ward_id;
        $obj->room_id = $request->room_id;
        $obj->bed_id = $request->bed_id;
        $obj->department_id = $request->department_id;
        $obj->admission_date = $admissionDate;
        $obj->remarks = $request->remarks;
        $obj->discharge_date = $dischargeDate;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Patient admitted successfully');
        return Redirect::route('admit_patients.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $obj = AdmitPatients::find($request->id);
        request()->validate([
            'ward_id' => ['required'],
            'room_id' => ['required'],
            'bed_id' => ['required'],
            'department_id' => ['required'],
            'admission_date' => ['required', 'date_format:d/m/Y H:i'],
            'discharge_date' => ['nullable', 'date_format:d/m/Y H:i'],
        ], [
            'ward_id.required' => 'Ward is required',
            'room_id.required' => 'Room is required',
            'bed_id.required' => 'Bed is required',
            'department_id.required' => 'Department is required',
            'admission_date.required' => 'Admission date is required',
            'admission_date.date_format' => 'Admission date must be in correct format (DD/MM/YYYY HH:mm)',
            'discharge_date.date_format' => 'Discharge date must be in correct format (DD/MM/YYYY HH:mm)',
        ]);

        $admissionDate = Carbon::createFromFormat('d/m/Y H:i', request('admission_date'))->format('Y-m-d H:i');
        $dischargeDate = request('discharge_date') ? Carbon::createFromFormat('d/m/Y H:i', request('discharge_date'))->format('Y-m-d H:i') : null;

        $obj->ward_id = $request->ward_id;
        $obj->room_id = $request->room_id;
        $obj->bed_id = $request->bed_id;
        $obj->department_id = $request->department_id;
        $obj->admission_date = $admissionDate;
        $obj->remarks = $request->remarks;
        $obj->discharge_date = $dischargeDate;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Patient admission updated successfully');
        return Redirect::route('admit_patients.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Patient admission has been deleted successfully',
        ]);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class, 'bed_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
