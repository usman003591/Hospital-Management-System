<?php

namespace App\Models;


use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicines extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'medicines';

    protected $fillable = [
        'name',
        'short_name',
        'brand_id',
        'number',
        'description',
        'image_name',
        'image_path',
        'cost',
        'medicine_category_id',
        'is_in_house',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'verification_status',
        'is_manual',
        'approved_by',
        'rejected_by',
    ];
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveMedicines()
    {
        return self::where('status', 1)->get();
    }

    public static function getForSelect()
    {
        return self::where('status', 1)->get();
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

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required', Rule::unique('medicines', 'name')->whereNull('deleted_at')],
            'is_in_house' => ['required'],
            'medicine_category_id' => ['nullable'],
            'packet_price' => ['required'],
            'packet_items' => ['required'],
        ]);

        $medicine_price = $request->packet_price/$request->packet_items;

        $this->name = $request->name;
        $this->medicine_category_id = $request->medicine_category_id;
        $this->packet_price = $request->packet_price;
        $this->packet_items = $request->packet_items;
        $this->is_in_house = $request->is_in_house;
        $this->cost = $medicine_price;
        $this->status = 1;
        $this->created_by = auth()->user()->id;
        $this->save();

        session()->flash('success', 'Medicine created successfully');
        return Redirect::route('medicines.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required', Rule::unique('medicines', 'name')->ignore($this->id)->whereNull('deleted_at')],
            'is_in_house' => ['required'],
            'medicine_category_id' => ['nullable'],
            'packet_price' => ['required'],
            'packet_items' => ['required'],
        ]);

        $medicine_price = $request->packet_price/$request->packet_items;

        $this->name = $request->name;
        $this->medicine_category_id = $request->medicine_category_id;
        $this->packet_price = $request->packet_price;
        $this->packet_items = $request->packet_items;
        $this->is_in_house = $request->is_in_house;
        $this->cost = $medicine_price;
        $this->is_in_house = $request->is_in_house;
        $this->updated_by = auth()->user()->id;
        $this->update();

        session()->flash('success', 'Medicine updated successfully');
        return Redirect::route('medicines.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Medicine deleted successfully',
        ]);
    }
}
