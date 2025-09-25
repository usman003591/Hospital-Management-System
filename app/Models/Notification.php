<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Hospital;
use App\Models\NotificationCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'name',
        'hospital_id',
        'notification_slug',
        'description',
        'notification_category_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function category()
    {
        return $this->belongsTo(NotificationCategory::class, 'notification_category_id');
    }


    public static function getAll()
{
    $search = request()->only(['q', 'status', 'category']);

    $data = self::with('category');

    if (!empty($search['q'])) {
        $data->where(function ($query) use ($search) {
            $query->where('name', 'ilike', '%' . $search['q'] . '%')
                ->orWhere('notification_slug', 'ilike', '%' . $search['q'] . '%')
                ->orWhereHas('category', fn($q) => $q->where('name', 'ilike', '%' . $search['q'] . '%'));
        });
    }

    if (array_key_exists('status', $search) && ($search['status'] !== null && $search['status'] !== '')) {
        $data->where('status', $search['status']);
    }

    if (array_key_exists('category', $search) && !empty($search['category'])) {
        $data->where('notification_category_id', $search['category']);
    }

    return [
        'search' => $search,
        'data' => $data->latest()->paginate(10),
    ];
}


    public function addForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'hospital_id' => ['required'],
            'notification_slug' => 'required|string|unique:notifications,notification_slug,NULL,id,deleted_at,NULL',
            'description' => 'required|string|max:500',
            'notification_category_id' => 'required|exists:notification_categories,id',
        ]);

        $this->create([
            'name' => $request->name,
            'notification_slug' => $request->notification_slug,
            'description' => $request->description,
            'hospital_id'=> $request->hospital_id,
            'notification_category_id' => $request->notification_category_id,
            'status' => 1,
            'created_by' => auth()->id(),
        ]);

        session()->flash('success', 'Notification added successfully.');
        return redirect()->route('notifications.index');
    }

    public function updateForm(Request $request)
    {
        $notification = self::findOrFail($request->id);

        $request->validate([
            'name' => 'required|string|max:100',
            'notification_slug' => [
                'required',
                'string',
                Rule::unique('notifications')->ignore($notification->id)->whereNull('deleted_at')
            ],
            'description' => 'required|string|max:500',
            'hospital_id' => ['required'],
            'notification_category_id' => 'required|exists:notification_categories,id',
            'status' => 'required|integer',
        ]);

        $notification->update([
            'name' => $request->name,
            'notification_slug' => $request->notification_slug,
            'description' => $request->description,
             'hospital_id'=> $request->hospital_id,
            'notification_category_id' => $request->notification_category_id,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        session()->flash('success', 'Notification updated successfully.');
        return redirect()->route('notifications.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->id();
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Notification deleted successfully.',
        ]);
    }
}
