<?php

namespace App\Models;
use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pos_cashiers';

    protected $fillable = ['name','phone','email', 'password', 'status', 'created_by', 'updated_by', 'deleted_by'];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActiveDepartments()
    {
        return self::where('status', 1)->get();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('pos_cashiers.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('pos_cashiers.status', 0);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required'],
            'phone' => ['required', 'digits_between:10,11'],
            'password' => ['required', 'string', 'max:255', 'min:8'],
            'email' => [
                'nullable',
                'email',
                'max: 100',
                Rule::unique(Cashier::class, 'email')->whereNull('deleted_at')
            ],
        ]);

        $obj = new Cashier;
        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->phone = $request->phone;
        $obj->password = bcrypt($request->password);
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Cashier created successfully');
        return Redirect::route('cashiers.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = Cashier::find($request->id);

        $request->validate([
            'name' => ['required'],
            'phone' => ['required', 'digits_between:10,11'],
            'password' => ['required', 'string', 'max:255', 'min:8'],
            'email' => [
                'nullable',
                'email',
                'max: 100',
            ],
            'status' => ['required'],
        ]);

        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->phone = $request->phone;
        $obj->password = bcrypt($request->password);
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Cashier updated successfully');
        return Redirect::route('cashiers.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Cashier has been deleted successfully',
        ]);
    }
}
