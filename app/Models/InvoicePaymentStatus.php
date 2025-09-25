<?php

namespace App\Models;

use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoicePaymentStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'invoice_payment_statuses';

    protected $fillable = ['name', 'status', 'created_by', 'updated_by', 'deleted_by'];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getActivePaymentStatuses()
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

        $data = self::select(['invoice_payment_statuses.*']);

        if ($search['q']) {
            $data = $data->where('invoice_payment_statuses.name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('invoice_payment_statuses.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('invoice_payment_statuses.status', 0);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderBy('invoice_payment_statuses.created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required', Rule::unique('invoice_payment_statuses', 'name')->whereNull('deleted_at')],
        ]);

        $this->name = $request->name;
        $this->status = 1;
        $this->created_by = auth()->user()->id;
        $this->save();

        session()->flash('success', 'Invoice payment status created successfully');
        return Redirect::route('invoice_payment_statuses.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'name' => ['required', Rule::unique('invoice_payment_statuses', 'name')->ignore($this->id)->whereNull('deleted_at')],
        ]);

        $this->name = $request->name;
        $this->status = $request->status;
        $this->updated_by = auth()->user()->id;
        $this->update();

        session()->flash('success', 'Invoice payment status updated successfully');
        return Redirect::route('invoice_payment_statuses.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Invoice payment status deleted successfully',
        ]);
    }
}
