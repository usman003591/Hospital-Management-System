<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralPhysicalExamination extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'description', 'parent_id', 'created_by', 'updated_by', 'verification_status', 'is_manual', 'approved_by', 'rejected_by',];

    //Relationships
    public function cdGeneralPhysicalExaminations()
    {
        return $this->hasMany(CdGeneralPhysicalExamination::class, 'gpe_id');
    }

    public function cdGeneralPhysicalExaminationDetails()
    {
        return $this->hasMany(CdGeneralPhysicalExaminationDetail::class, 'gpe_id');
    }

    public static function getParentPhysicalExaminations()
    {
        return self::where('parent_id', 0)->get();
    }

    public static function getAllChildPhysicalExaminations()
    {
        return self::where('parent_id', '!=', 0)->where('verification_status', '!=', 'rejected')->get();
    }

    //Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getParentGPEs()
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

        $query = \DB::table('general_physical_examinations as gpe')
            ->leftJoin('general_physical_examinations as parent', 'gpe.parent_id', '=', 'parent.id')
            ->select([
                'gpe.*',
                'parent.name as parent_name',
                'parent.id as parent_id',
            ])
            ->whereNotNull('gpe.id')
            ->whereNull('gpe.deleted_at');

        if (!empty($search['q'])) {
            $query->where('gpe.name', 'ILIKE', '%' . $search['q'] . '%');
        }

        if (!is_null($search['parent_id'])) {
            if ($search['parent_id'] === '0' || $search['parent_id'] === 0) {
                $query->where('gpe.parent_id', 0);
            } else {
                $query->where('gpe.parent_id', $search['parent_id']);
            }
        }

        if (!is_null($search['verification_status'])) {
            $query->where('gpe.verification_status', $search['verification_status']);
        }

        $results = $query->orderByDesc('gpe.created_at')->paginate(10);

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

        $gpe = GeneralPhysicalExamination::create([
            'name' => request('name'),
            'description' => request('description'),
            'created_by' => auth()->user()->id
        ]);

        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $gpe->parent_id = request('parent_id');
            $gpe->update();
        }

        session()->flash('success', 'General physical examination created successfully');
        return Redirect::route('general_physical_examinations.index');
    }

    public function updateForm($id)
    {
        request()->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:250'],
        ]);

        $obj = GeneralPhysicalExamination::find($id);
        $obj->update([
            'name' => request('name'),
            'description' => request('description'),
            'updated_by' => auth()->user()->id
        ]);

        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $obj->parent_id = request('parent_id');
            $obj->update();
        }

        session()->flash('success', 'General physical examination updated successfully');
        return Redirect::route('general_physical_examinations.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'General physical examination has been deleted successfully',
        ]);
    }
}
