<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestigationAttachedField extends Model
{
    use SoftDeletes;

    protected $table = 'investigations_attached_fields';
    protected $fillable = ['name', 'investigation_id', 'investigation_custom_field_id', 'is_mandatory', 'sort_order', 'created_by', 'updated_by', 'deleted_by'];

    public static function softDeleteById($attachedId)
    {
        return self::where('id', $attachedId)->update([
            'deleted_at' => now()
        ]);
    }

    public static function getCustomAttachedFieldData ($investigation_attached_field_id) {

       $investigationAttachedFieldData = InvestigationAttachedField::leftjoin(
        'investigations_custom_fields as icf',
        'icf.id',
        'investigations_attached_fields.investigation_custom_field_id'
        )->select(
        'icf.*',
        'investigations_attached_fields.id as investigation_attached_field_id',
        'investigations_attached_fields.investigation_id as investigation_id'
        )
        ->where('investigations_attached_fields.id',$investigation_attached_field_id)
        ->first();

        return $investigationAttachedFieldData;
    }

    public static function attachOrRestoreField($investigationId, $fieldId, $userId)
    {
        $existing = self::withTrashed()
            ->where('investigation_id', $investigationId)
            ->where('investigation_custom_field_id', $fieldId)
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
                $existing->update([
                    'created_by' => $userId,
                    'updated_at' => now(),
                ]);
            }

            return [
                'message' => 'Field restored successfully!',
                'attached_id' => $existing->id
            ];
        }

        $attached = self::create([
            'investigation_id' => $investigationId,
            'investigation_custom_field_id' => $fieldId,
            'created_by' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [
            'message' => 'Field attached successfully!',
            'attached_id' => $attached->id
        ];
    }
}
