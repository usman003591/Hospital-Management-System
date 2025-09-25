<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use App\Models\RoleRightsAllowed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveRoles()
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

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select(['roles.*']);

        if ($search['q']) {
            $data = $data->where('roles.name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('roles.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('roles.status', 0);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderBy('roles.created_at', 'desc')->where('roles.id','!=',1)->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required', 'max:50', Rule::unique('roles', 'name')->whereNull('deleted_at')],
        ],[
            'name.required' => 'Role name is required',
        ]);

        $this->name = $request->name;
        $this->status = 1;
        $this->created_by = auth()->user()->id;
        $this->save();

        session()->flash('success', 'Role created successfully');
        return Redirect::route('roles.index');
    }

    public function updateForm($request = false)
    {


        if ($request === false) {
            $request = request();
        }


        $request->validate([
            'name' => ['required', 'max:50', Rule::unique('roles', 'name')->ignore($this->id)->whereNull('deleted_at')],
        ],[
            'name.required' => 'Role name is required',
        ]);

        $this->name = $request->name;
        $this->status = $request->status;
        $this->updated_by = auth()->user()->id;
        $this->update();

        session()->flash('success', 'Role updated successfully');
        return Redirect::route('roles.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Role has been deleted successfully',
        ]);
    }

    public function checkPermissions()
    {
        $data = RoleRightsAllowed::getAll($this->id);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function getPermission()
    {
        $data = RoleRightsAllowed::getAll($this->id);
        return $data;
    }

    public function permissions()
    {

        if (isset($this->permission))
            return $this->permission;

        $rights = $this->getPermission();

        $rtn = '';
        if ($rights) {
            foreach ($rights as $right) {
                $rtn .= "|" . $right->rights_slug . "|";
            }
            return $this->permission = $rtn;
        }
    }

    public function updatePermission($request = false)
    {
        return RoleRightsAllowed::updatePermission($this->id, $request);
    }
}
