<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystematicPhysicalExamination extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'description', 'parent_id', 'created_by', 'updated_by', 'deleted_by', 'verification_status', 'is_manual', 'approved_by', 'rejected_by'];

    //Relationships
    public function cdSystematicPhysicalExaminations()
    {
        return $this->hasMany(CdSystematicPhysicalExamination::class, 'spe_id');
    }

    public static function getParentSystematicPhysicalExamination()
    {
        return self::where('parent_id', 0)->get();
    }

    public static function getAllChildSystematicPhysicalExamination()
    {
        return self::where('parent_id', '!=', 0)->where('verification_status', '!=', 'rejected')->get();
    }

    //Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getParentSPEs()
    {
        return self::where('parent_id', 0)->get();
    }

    public static function getAll()
    {
        $request = request();

        $search = [
            'q' => $request->input('q'),
            'parent_id' => $request->input('parent_id'),
            'verification_status' => $request->input('verification_status'),
        ];


        $query = \DB::table('systematic_physical_examinations as spe')
            ->leftjoin('systematic_physical_examinations as systematic', 'spe.parent_id', '=', 'systematic.id')
            ->select([
                'spe.*',
                'systematic.name as parent_name',
                'systematic.id as parent_id'
            ]);

        if (!empty($search['q'])) {
            $query->where('spe.name', 'ILIKE', '%' . $search['q'] . '%');
        }

        if (!is_null($search['parent_id'])) {
            if ($search['parent_id'] === '0' || $search['parent_id'] === 0) {
                $query->where('spe.parent_id', 0);
            } else {
                $query->where('spe.parent_id', $search['parent_id']);
            }
        }

        if (!is_null($search['verification_status'])) {
            $query->where('spe.verification_status', $search['verification_status']);
        }

        $results = $query->orderByDesc('spe.created_at')->paginate(10);

        return [
            'search' => $search,
            'data' => $results,
            'verification_status' => $search['verification_status']
        ];
    }

    public function addForm()
    {
        request()->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:250']
        ]);

        $spe = SystematicPhysicalExamination::create([
            'name' => request('name'),
            'description' => request('description'),
            'created_by' => auth()->user()->id
        ]);

        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $spe->parent_id = request('parent_id');
            $spe->update();
        }

        session()->flash('success', 'Systematic physical examination created successfully');
        return Redirect::route('systematic_physical_examinations.index');
    }

    public function updateForm($id)
    {
        request()->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:250'],
        ]);

        $obj = SystematicPhysicalExamination::find($id);
        $obj->update([
            'name' => request('name'),
            'description' => request('description'),
            'updated_by' => auth()->user()->id
        ]);

        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $obj->parent_id = request('parent_id');
            $obj->update();
        }

        session()->flash('success', 'Systematic physical examination updated successfully');
        return Redirect::route('systematic_physical_examinations.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Systematic physical examination has been deleted successfully',
        ]);
    }
}
