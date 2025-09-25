<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pos_payment_methods';

    protected $fillable = ['name','status','payment_icon', 'created_by', 'updated_by', 'deleted_by'];

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
                $data = $data->where('pos_payment_methods.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('pos_payment_methods.status', 0);
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
            'name' => ['required']
        ]);

        $obj = new PaymentMethod;
        $obj->name = $request->name;
        $obj->payment_icon = $request->payment_icon;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Payment method created successfully');
        return Redirect::route('payment_methods.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = PaymentMethod::find($request->id);

        $request->validate([
            'name' => ['required'],
            'status' => ['required'],
        ]);

        $obj->name = $request->name;
        $obj->status = $request->status;
        $obj->payment_icon = $request->payment_icon;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Payment method updated successfully');
        return Redirect::route('payment_methods.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Payment method has been deleted successfully',
        ]);
    }
}
