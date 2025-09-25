<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class InvestigationCustomField extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'investigations_custom_fields';

    protected $fillable = [
        'name',
        'unit',
        'male_reference_min',
        'male_reference_max',
        'female_reference_min',
        'female_reference_max',
        'all_reference_min',
        'all_reference_max',
        'reference_notes',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('name', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderBy('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required', 'max:100'],
            'unit' => ['required', 'string', 'max:20'],
            'male_reference_min' => ['required', 'string'],
            'male_reference_max' => ['required', 'string'],
            'female_reference_min' => ['required', 'string'],
            'female_reference_max' => ['required', 'string'],
            'all_reference_min' => ['required', 'string'],
            'all_reference_max' => ['required', 'string'],
            'reference_notes' => ['nullable', 'string'],
        ]);

        $obj = new InvestigationCustomField;
        $obj->name = $request->name;
        $obj->unit = $request->unit;
        $obj->male_reference_min = $request->male_reference_min;
        $obj->male_reference_max = $request->male_reference_max;
        $obj->female_reference_min = $request->female_reference_min;
        $obj->female_reference_max = $request->female_reference_max;
        $obj->all_reference_min = $request->all_reference_min;
        $obj->all_reference_max = $request->all_reference_max;
        $obj->reference_notes = $request->reference_notes;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Investigation Custom Field created successfully');
        return Redirect::route('investigation_custom_fields.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = InvestigationCustomField::find($request->id);

        $request->validate([
            'name' => ['required', 'max:100'],
            'unit' => ['required', 'string', 'max:20'],
            'male_reference_min' => ['required', 'string'],
            'male_reference_max' => ['required', 'string'],
            'female_reference_min' => ['required', 'string'],
            'female_reference_max' => ['required', 'string'],
            'all_reference_min' => ['required', 'string'],
            'all_reference_max' => ['required', 'string'],
            'reference_notes' => ['nullable', 'string'],
        ]);

        $obj->name = $request->name;
        $obj->unit = $request->unit;
        $obj->male_reference_min = $request->male_reference_min;
        $obj->male_reference_max = $request->male_reference_max;
        $obj->female_reference_min = $request->female_reference_min;
        $obj->female_reference_max = $request->female_reference_max;
        $obj->all_reference_min = $request->all_reference_min;
        $obj->all_reference_max = $request->all_reference_max;
        $obj->reference_notes = $request->reference_notes;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Investigation Custom Field updated successfully');
        return Redirect::route('investigation_custom_fields.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Investigation Custom Field has been deleted successfully',
        ]);
    }

    // Relationship for attached fields
    public function attachedFields()
    {
        return $this->hasMany(DB::raw('investigations_attached_fields'), 'investigation_custom_field_id', 'id');
    }

    // Method to get available attached fields (not already attached to this custom field)
    public function getAvailableAttachedFields()
    {
        return DB::table('investigations_attached_fields')
            ->whereNotIn('id', function ($query) {
                $query->select('id')
                    ->from('investigations_attached_fields')
                    ->where('investigation_custom_field_id', $this->id);
            })
            ->get();
    }

    // Method to update attached fields (simulating the controller logic)
    public function updateAttachedFields($attachedFieldIds, $investigationId)
    {
        // Delete existing attached fields for this custom field
        DB::table('investigations_attached_fields')
            ->where('investigation_custom_field_id', $this->id)
            ->delete();

        // Process attached field IDs (both custom field details and database IDs)
        foreach ($attachedFieldIds as $index => $fieldId) {
            if (is_numeric($fieldId)) { // Handle database-stored attached fields
                DB::table('investigations_attached_fields')->insert([
                    'investigation_custom_field_id' => $this->id,
                    'investigation_id' => $investigationId,
                    'is_mandatory' => true,
                    'sort_order' => $index,
                    'created_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else { // Handle custom field details (e.g., 'name', 'unit', etc.)
                // You can store these in a separate table or handle them differently
                // For now, I'll log them or store in a JSON column if needed
                // Example: Store in a JSON column or separate table for custom field attachments
                $this->update([
                    'attached_details' => json_encode(array_unique(array_merge(
                        json_decode($this->attached_details ?? '[]', true),
                        [$fieldId => $index]
                    )))
                ]);
            }
        }
    }
}
