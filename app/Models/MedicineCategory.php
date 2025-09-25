<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pos_medicine_categories';

    protected $fillable = [
        'name',
        'status',
        'image_name',
        'image_path',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $uploadPath = 'medicine-categories';



    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveCategories()
    {
        $preferences = UserPreferences::getPreferences();

        return self::where('status', 1)->get();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select(['pos_medicine_categories.*',]);

        if ($search['q']) {
            $data = $data->where('pos_medicine_categories.name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('pos_medicine_categories.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('pos_medicine_categories.status', 0);
            }
        }



        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('pos_medicine_categories.created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $obj = new MedicineCategory;
        $obj->name = $request->name;
        $obj->status = 1; // Set default status to active

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();

            // Store image in storage/app/public/medicine-categories
            $imagePath = $image->storeAs($this->uploadPath, $imageName, 'public');

            $obj->image_name = $imageName;
            $obj->image_path = $imagePath;
        }

        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Medicine category created successfully');
        return Redirect::route('medicine_categories.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $obj = MedicineCategory::find($request->id);

        $request->validate([
            'name' => ['required'],
            'status' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $obj->name = $request->name;
        $obj->status = $request->status;

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($obj->image_path) {
                Storage::disk('public')->delete($obj->image_path);
            }

            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();

            // Store new image
            $imagePath = $image->storeAs($this->uploadPath, $imageName, 'public');

            $obj->image_name = $imageName;
            $obj->image_path = $imagePath;
        }

        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Medicine category updated successfully');
        return Redirect::route('medicine_categories.index');
    }

    public function deleteObj()
    {
        // Delete associated image if exists
        if ($this->image_path) {
            Storage::disk('public')->delete($this->image_path);
        }

        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Medicine category has been deleted successfully',
        ]);
    }

    // Helper method to get full image URL
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }
        return null;
    }

    // Helper method to check if category has image
    public function hasImage()
    {
        return !empty($this->image_path) && Storage::disk('public')->exists($this->image_path);
    }
}
