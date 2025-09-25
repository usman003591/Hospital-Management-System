<?php

namespace App\Models;

use App\Models\RoleRights;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleRightModules extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'role_right_modules';

    protected $fillable = [
        'name',
        'parent_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function addNew($name, $id = false)
    {
        $obj = new RoleRightModules();
        $obj->name = $name;
        $obj->parent_id = $id ? $id : 0;
        $obj->created_by = auth()->user()->id;
        $obj->save();
        return $obj->id;
    }

    public static function getAllParents()
    {
        return self::where('parent_id', 0)->get();
    }

    public function child_data()
    {
        if (isset($this->childs))
            return $this->childs;

        return $this->childs = $this->getAllChild();

    }

    public function getAllChild()
    {
        return RoleRightModules::where('parent_id', $this->id)->get();
    }

    public function permission_data()
    {
        if (isset($this->permissions))
            return $this->permissions;

        return $this->permissions = RoleRights::getPermissions($this->id);
    }

    public static function getForSelect()
    {
        return self::select('name', 'id')->get();
    }

    public static function getById($id)
    {
        return self::find($id);
    }

}
