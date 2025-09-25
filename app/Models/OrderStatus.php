<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pos_order_statuses';

    protected $fillable = ['name','status', 'created_by', 'updated_by', 'deleted_by'];

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
                $data = $data->where('pos_order_statuses.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('pos_order_statuses.status', 0);
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

        $obj = new OrderStatus;
        $obj->name = $request->name;
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Order status created successfully');
        return Redirect::route('order_statuses.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = OrderStatus::find($request->id);

        $request->validate([
            'name' => ['required'],
            'status' => ['required'],
        ]);

        $obj->name = $request->name;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Order status updated successfully');
        return Redirect::route('order_statuses.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Order status has been deleted successfully',
        ]);
    }
}
