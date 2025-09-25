<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleRightsAllowed extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'role_rights_allowed';

    protected $fillable = [
        'name',
        'role_right_id',
        'role_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function getAll($roleId) {
        return self::where('role_id', $roleId)
            ->leftjoin('role_rights as rr', 'rr.id', 'role_rights_allowed.role_right_id')
            ->get();
    }

    public static function updatePermission($roleId, $permission) {
        $obj = self::where('role_id', $roleId)->where('role_right_id', $permission['right_id'])->withTrashed()->first();


        if($permission['value'] == "false" && $obj) {
            $obj->deleted_by = auth()->user()->id;
            $obj->delete();
        }

        if($permission['value'] == "true" && $obj) {
            $obj->deleted_at = null;
            $obj->created_by = auth()->user()->id;
            $obj->save();
        }

        if($permission['value'] == "true" && !$obj) {
            $obj = new RoleRightsAllowed();
            $obj->name = "temp";
            $obj->role_right_id = $permission['right_id'];
            $obj->role_id = $roleId;
            $obj->created_by = auth()->user()->id;
            $obj->save();
        }
    }


}
