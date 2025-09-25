<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class Procedure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status', 'verification_status', 'is_manual', 'created_by', 'updated_by', 'deleted_by', 'approved_by', 'rejected_by'];
    protected $table = 'procedures';

    public static function getById($id)
    {
        return self::find($id);
    }


    public static function getActiveProcedures()
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

    public function addForm($request)
    {
        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('procedures', 'name')->whereNull('deleted_at')],
            'status' => ['required', 'in:0,1'],
        ], [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'status.required' => 'Status is required',
        ]);

        $validatedData['created_by'] = auth()->id();

        self::create($validatedData);

        session()->flash('success', 'Procedure created successfully.');
        return Redirect::route('procedures.index');
    }

    public function updateForm($request)
    {
        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('procedures', 'name')->ignore($this->id)->whereNull('deleted_at')],
            'status' => ['required', 'in:0,1'],
            // 'verification_status' => ['required', 'in:approved,pending,rejected'],
        ], [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'status.required' => 'Status is required',
            // 'verification_status.required' => 'Verification status is required',
        ]);

        $validatedData['updated_by'] = auth()->id();

        $this->update($validatedData);

        session()->flash('success', 'Procedure updated successfully.');
        return Redirect::route('procedures.index');
    }


}
