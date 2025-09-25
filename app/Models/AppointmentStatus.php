<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class AppointmentStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 'appointment_statuses';

    public static function getById($id)
    {
        return self::find($id);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'appointment_status_id');
    }


    public static function getActiveAppointmentStatuses()
    {
        return self::where('status', 1)->get();
    }

    public static function getForSelect()
    {
        return self::pluck('name', 'id');
    }


    public static function getAll()
    {
        $request = request();
        $search = [
            'q' => $request->get('q', ''),
            'status' => $request->get('status', null),
        ];

        $query = self::query();

        if (!empty($search['q'])) {
            $query->where('name', 'ILIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== null) {
            $query->where('status', $search['status']);
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return ['search' => $search, 'data' => $data];
    }

    public function addForm($request)
    {
        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('appointment_statuses', 'name')->whereNull('deleted_at')],
            'status' => ['required', 'in:0,1'],
        ], [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'status.required' => 'Status is required',
        ]);

        $validatedData['created_by'] = auth()->id();

        self::create($validatedData);

        session()->flash('success', 'Appointment status created successfully.');
        return Redirect::route('appointment_statuses.index');
    }

    public function updateForm($request)
    {
        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('appointment_statuses', 'name')->ignore($this->id)->whereNull('deleted_at')],
            'status' => ['required', 'in:0,1'],
        ], [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'status.required' => 'Status is required',
        ]);

        $validatedData['updated_by'] = auth()->id();

        $this->update($validatedData);

        session()->flash('success', 'Appointment status updated successfully.');
        return Redirect::route('appointment_statuses.index');
    }


}
