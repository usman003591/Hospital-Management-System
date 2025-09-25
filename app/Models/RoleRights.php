<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleRights extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'role_rights';

    protected $fillable = [
        'name',
        'rights_slug',
        'role_right_module_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    public static function addNew($id, $rights)
    {
        //dd($rights);
        foreach ($rights as $r) {
            $obj = new RoleRights();
            $name = explode('_', $r)[0];
            $obj->name = ucfirst($name);
            $obj->rights_slug = $r;
            $obj->role_right_module_id = $id;
            $obj->created_by = auth()->user()->id;
            $obj->save();
        }
    }

    public static function getPermissions($moduleId)
    {
        return self::where('role_right_module_id', $moduleId)->get();
    }

    public function createRoleRightSlug($str, $module_name, $module, $delimiter = '_')
    {

        $vars = explode(" ", $str);
        $data = '';

        $slug = strtolower(trim(preg_replace(
            '/[\s-]+/',
            $delimiter,
            preg_replace(
                '/[^A-Za-z0-9-]+/',
                $delimiter,
                preg_replace(
                    '/[&]/',
                    'and',
                    preg_replace(
                        '/[\']/',
                        '',
                        iconv('UTF-8', 'ASCII//TRANSLIT', $str)
                    )
                )
            )
        ), $delimiter));

        $module_name = strtolower(trim(preg_replace(
            '/[\s-]+/',
            $delimiter,
            preg_replace(
                '/[^A-Za-z0-9-]+/',
                $delimiter,
                preg_replace(
                    '/[&]/',
                    'and',
                    preg_replace(
                        '/[\']/',
                        '',
                        iconv('UTF-8', 'ASCII//TRANSLIT', $module_name)
                    )
                )
            )
        ), $delimiter));

        return $slug . '_' . strtolower($module_name) . '_' . $module;

    }

    public static function getForSelect()
    {
        return self::select('name', 'id')->get();
    }
}
