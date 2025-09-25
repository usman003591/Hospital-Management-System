<?php


namespace App\Http\Controllers\Investigations;

use Illuminate\Http\Request;
use App\Models\UserPreferences;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\InvestigationCustomField;

class InvestigationCustomFieldsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_investigations_custom_fields_59')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.investigation_custom_fields.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new InvestigationCustomField();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new InvestigationCustomField();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_investigations_custom_fields_59')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.investigation_custom_fields.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_investigations_custom_fields_59')) {
               return ErrorMessage(403);
        }
        $obj = InvestigationCustomField::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.investigation_custom_fields.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_investigations_custom_fields_59')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = InvestigationCustomField::find($id);
            return $obj->deleteObj();
        }
    }

    // New method for the detail page with Kanban boards
    // In InvestigationCustomFieldsController.php
public function show($id)
{
    $customField = InvestigationCustomField::getById($id);
    if (!$customField) {
        abort(404, 'Investigation Custom Field not found');
    }

    $preferences = UserPreferences::getPreferences();
    $availableAttachedFields = $customField->getAvailableAttachedFields();
    $attachedFields = DB::table('investigations_attached_fields')
        ->where('investigation_custom_field_id', $id)
        ->orderBy('sort_order')
        ->get();

    // Fetch a valid investigation_id (e.g., from the user's session, a default, or related data)
    $investigationId = request()->query('investigation_id', DB::table('investigations')->first()->id ?? 1);

    return view('modules.investigation_custom_fields.detail', compact('customField', 'preferences', 'availableAttachedFields', 'attachedFields', 'investigationId'));
}

    // New method to handle updating attached fields via drag-and-drop
    public function updateAttachedFields(Request $request, $id)
{
    \Log::info('Request Data: ', $request->all()); // Debugging log
    $customField = InvestigationCustomField::find($id);
    if (!$customField) {
        return response()->json(['status' => 404, 'message' => 'Investigation Custom Field not found'], 404);
    }

    $fieldId = $request->input('field_id');
    $fieldType = $request->input('field_type'); // 'custom' or 'db'
    $targetColumn = $request->input('target_column'); // 'available' or 'attached'
    $investigationId = $request->input('investigation_id', 1); // Default to 1 or a valid ID
    $attachedFieldIds = $request->input('attached_field_ids'); // From form submission

    // Validate investigation_id
    if (empty($investigationId)) {
        \Log::error('Investigation ID is missing or empty');
        return response()->json(['status' => 400, 'message' => 'Investigation ID is required'], 400);
    }

    // Ensure investigation_id exists in the investigations table
    if (!DB::table('investigations')->where('id', $investigationId)->exists()) {
        \Log::error('Invalid Investigation ID: ' . $investigationId);
        return response()->json(['status' => 400, 'message' => 'Invalid Investigation ID'], 400);
    }

    $userId = auth()->user()->id ?? 1; // Fallback to 1 if no authenticated user (for debugging)

    try {
        if ($fieldId && $fieldType && $targetColumn) {
            // Handle drag-and-drop AJAX update
            \Log::info('Processing drag-and-drop update: fieldId=' . $fieldId . ', fieldType=' . $fieldType . ', targetColumn=' . $targetColumn);
            if ($fieldType === 'custom') {
                if ($targetColumn === 'attached') {
                    // Add to attached fields (store in investigations_attached_fields)
                    $existingAttached = DB::table('investigations_attached_fields')
                        ->where('investigation_custom_field_id', $id)
                        ->where('name', $fieldId)
                        ->first();

                    if (!$existingAttached) {
                        \Log::info('Inserting new custom field: ' . $fieldId);
                        DB::table('investigations_attached_fields')->insert([
                            'investigation_custom_field_id' => $id,
                            'investigation_id' => $investigationId,
                            'name' => $fieldId,
                            'is_mandatory' => true,
                            'sort_order' => DB::table('investigations_attached_fields')
                                ->where('investigation_custom_field_id', $id)
                                ->max('sort_order') + 1 ?? 0,
                            'created_by' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        \Log::info('Field already attached: ' . $fieldId);
                    }
                } else {
                    // Remove from attached fields
                    \Log::info('Removing custom field from attached: ' . $fieldId);
                    DB::table('investigations_attached_fields')
                        ->where('investigation_custom_field_id', $id)
                        ->where('name', $fieldId)
                        ->delete();
                }
            } elseif ($fieldType === 'db') {
                if ($targetColumn === 'attached') {
                    $existing = DB::table('investigations_attached_fields')
                        ->where('id', $fieldId)
                        ->where('investigation_custom_field_id', $id)
                        ->first();
                    if (!$existing) {
                        \Log::info('Inserting new DB field: ' . $fieldId);
                        DB::table('investigations_attached_fields')->insert([
                            'investigation_custom_field_id' => $id,
                            'investigation_id' => $investigationId,
                            'id' => $fieldId,
                            'is_mandatory' => true,
                            'sort_order' => DB::table('investigations_attached_fields')
                                ->where('investigation_custom_field_id', $id)
                                ->max('sort_order') + 1 ?? 0,
                            'created_by' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        \Log::info('DB field already attached: ' . $fieldId);
                    }
                } else {
                    \Log::info('Removing DB field from attached: ' . $fieldId);
                    DB::table('investigations_attached_fields')
                        ->where('id', $fieldId)
                        ->where('investigation_custom_field_id', $id)
                        ->delete();
                }
            }
        } elseif ($attachedFieldIds) {
            // Handle form submission (Save Attached Fields button)
            $attachedFieldIds = json_decode($attachedFieldIds, true) ?? [];
            \Log::info('Decoded Attached Field IDs: ', $attachedFieldIds);

            // Clear existing attached fields for this custom field
            \Log::info('Clearing existing attached fields for custom field ID: ' . $id);
            DB::table('investigations_attached_fields')
                ->where('investigation_custom_field_id', $id)
                ->delete();

            // Reattach fields with new sort order
            foreach ($attachedFieldIds as $index => $fieldId) {
                \Log::info('Reattaching field: ' . $fieldId . ' at sort_order: ' . $index);
                if (is_numeric($fieldId)) {
                    // Handle database-stored attached fields
                    DB::table('investigations_attached_fields')->insert([
                        'investigation_custom_field_id' => $id,
                        'investigation_id' => $investigationId,
                        'id' => $fieldId,
                        'is_mandatory' => true,
                        'sort_order' => $index,
                        'created_by' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    // Handle custom field details (e.g., 'name', 'unit')
                    DB::table('investigations_attached_fields')->insert([
                        'investigation_custom_field_id' => $id,
                        'investigation_id' => $investigationId,
                        'name' => $fieldId,
                        'is_mandatory' => true,
                        'sort_order' => $index,
                        'created_by' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Attached fields updated successfully',
        ]);
    } catch (\Exception $e) {
        \Log::error('Database error in updateAttachedFields: ' . $e->getMessage());
        return response()->json(['status' => 500, 'message' => 'Error saving attached fields: ' . $e->getMessage()], 500);
    }
}
}
