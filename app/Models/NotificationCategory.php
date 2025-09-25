<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notification_categories';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    public static function getAll()
    {
        $search = request()->only(['q', 'status']);
        $data = self::query();

        if (!empty($search['q'])) {
            $data->where('name', 'ilike', '%' . $search['q'] . '%');
        }

        if (array_key_exists('status', $search) && ($search['status'] !== null && $search['status'] !== '')) {
            $data->where('status', $search['status']);
        }

        return [
            'search' => $search,
            'data' => $data->latest()->paginate(10),
        ];
    }


    public function addForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:notification_categories,name,NULL,id,deleted_at,NULL|max:100',
        ]);

        $this->create([
            'name' => $request->name,
            'status' => $request->status ?? 1,
            'created_by' => auth()->id(),
        ]);

        session()->flash('success', 'Category added successfully.');
        return redirect()->route('notification_categories.index');
    }


    public function updateForm(Request $request)
    {
        $category = self::findOrFail($request->id);

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('notification_categories')->ignore($category->id)->whereNull('deleted_at'),
                'max:100',
            ],
            'status' => 'required|integer',
        ]);

        $category->update([
            'name' => $request->name,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        session()->flash('success', 'Category updated successfully.');
        return redirect()->route('notification_categories.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->id();
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Category deleted successfully.',
        ]);
    }
}
