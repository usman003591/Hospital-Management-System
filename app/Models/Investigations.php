<?php

namespace App\Models;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Investigations extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'investigations';

    protected $fillable = ['name', 'status', 'description', 'type_id', 'created_by', 'updated_by', 'deleted_by','is_in_house', 'verification_status', 'is_manual', 'approved_by', 'rejected_by',];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveInvestigations()
    {
        return self::where('status', 1)->where('verification_status', '!=', 'rejected')->get();
    }

    public static function getInvestigationsByType($id)
    {
        return self::where('type_id', $id)->where('status', 1)->where('verification_status', '!=', 'rejected')->get();
    }


    public static function getInvestigationsByTypeAndInHouse($id)
    {
        return self::where('type_id', $id)->where('is_in_house',1)->where('status', 1)->where('verification_status', '!=', 'rejected')->get();
    }

    public static function getSelectedPathologyInvestigations($lab_group_id, $pathology_id)
    {
            $data = DB::table('investigations as inv')
            ->join('lab_group_tests as lgi', 'inv.id', '=', 'lgi.investigation_id')
            ->where('lgi.lab_group_id', $lab_group_id)
            ->where('inv.type_id', $pathology_id)
            ->select('inv.*')
            ->get();

            return $data;
    }

    public static function getInvestigationsByTypeAndInHouseWithPrices($investigation_type_id)
    {
        $today = now()->toDateString();

        $currPrice = DB::table('lab_investigation_prices')
            ->selectRaw("
                DISTINCT ON (investigation_id)
                investigation_id, id AS lab_price_id, price, valid_from, valid_to
            ")
            ->where(function ($q) use ($today) { $q->whereNull('valid_from')->orWhere('valid_from', '<=', $today);  })
            ->where(function ($q) use ($today) { $q->whereNull('valid_to')->orWhere('valid_to', '>=', $today); })
            ->orderBy('investigation_id')
            ->orderByRaw('COALESCE(valid_from, DATE \'0001-01-01\') DESC')
        ;

        $data = DB::table('investigations as inv')
            ->where('inv.type_id', $investigation_type_id)
            ->where('inv.is_in_house', 1)
            ->where('inv.status', 1)
            ->where('inv.verification_status', '!=', 'rejected')
            ->leftJoinSub($currPrice, 'lip', function ($join) {
                $join->on('lip.investigation_id', '=', 'inv.id');
            })
            ->whereNotNull('lip.price')
            ->select('inv.*', 'lip.lab_price_id', 'lip.price', 'lip.valid_from', 'lip.valid_to')
            ->get();

        return $data;
    }

    public static function getForSelect()
    {
        return self::where('status', 1)->where('verification_status', '!=', 'rejected')->get();
    }

    public static function getAll()
    {
        $request = request();

        $search = [
            'q' => $request->input('q'),
            'investigation_type' => $request->input('investigation_type'),
            'verification_status' => $request->input('verification_status'),
        ];

        $query = self::leftjoin('investigation_types as it', 'it.id', 'investigations.type_id')->select(['it.name as type_name', 'investigations.*'])->whereNotNull('it.id')
            ->whereNull('it.deleted_at');

        if (!empty($search['q'])) {
            $query->where('investigations.name', 'ILIKE', '%' . $search['q'] . '%');
        }

        if (!is_null($search['investigation_type'])) {
            $query->where('investigations.type_id', $search['investigation_type']);
        }

        if (!is_null($search['verification_status'])) {
            $query->where('investigations.verification_status', $search['verification_status']);
        }

        $results = $query->orderByDesc('investigations.created_at')->paginate(10);

        return [
            'search' => $search,
            'data' => $results,
            'verification_status' => $search['verification_status']
        ];
    }

    public function getAttachedFields()
    {
        return DB::table('investigations_attached_fields as iaf')
            ->join('investigations_custom_fields as icf', 'iaf.investigation_custom_field_id', '=', 'icf.id')
            ->where('iaf.investigation_id', $this->id)
            ->whereNull('iaf.deleted_at')
            ->select('iaf.id as attached_id', 'icf.id as field_id', 'icf.name', 'icf.unit')
            ->get();
    }

    public function getAvailableCustomFields()
    {
        return DB::table('investigations_custom_fields as icf')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('investigations_attached_fields as iaf')
                    ->whereColumn('iaf.investigation_custom_field_id', 'icf.id')
                    ->whereNull('iaf.deleted_at');
            })
            ->select('icf.id as field_id', 'icf.name', 'icf.unit')
            ->get();
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required', Rule::unique('investigations', 'name')->whereNull('deleted_at'), 'max:200'],
            'type_id' => ['required', 'exists:investigation_types,id'],
            'is_in_house' => ['required'],
        ], [
            'name.required' => 'The investigation name is required.',
            'name.unique' => 'The investigation name already exists.',
            'name.max' => 'The investigation name must not be greater than 200 characters.',
            'type_id.required' => 'The investigation type is required.',
            'type_id.exists' => 'The selected investigation type does not exist.',
        ]);

        $this->name = $request->name;
        $this->description = $request->description;
        $this->status = 1;
        $this->is_in_house = $request->is_in_house;
        $this->type_id = $request->type_id;
        $this->created_by = auth()->user()->id;
        $this->save();

        session()->flash('success', 'Investigation created successfully');
        return Redirect::route('investigations.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required', Rule::unique('investigations', 'name')->ignore($this->id)->whereNull('deleted_at'), 'max:200'],
            'type_id' => ['required', 'exists:investigation_types,id'],
            'is_in_house' => ['required'],
        ], [
            'name.required' => 'The investigation name is required.',
            'name.unique' => 'The investigation name already exists.',
            'name.max' => 'The investigation name must not be greater than 200 characters.',
            'type_id.required' => 'The investigation type is required.',
            'type_id.exists' => 'The selected investigation type does not exist.',
        ]);

        $this->name = $request->name;
        $this->description = $request->description;
        $this->type_id = $request->type_id;
        $this->is_in_house = $request->is_in_house;
        $this->updated_by = auth()->user()->id;
        $this->update();

        session()->flash('success', 'Investigation updated successfully');
        return Redirect::route('investigations.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Investigation deleted successfully',
        ]);
    }
}
