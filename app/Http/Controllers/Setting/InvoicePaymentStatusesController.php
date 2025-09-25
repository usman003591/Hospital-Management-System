<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\InvoicePaymentStatus;

class InvoicePaymentStatusesController extends Controller
{
    public function create(Request $request)
    {
              if(!checkPersonPermission('create_invoice_payment_statuses_13')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $ips = 'Invoice Payment Status';
        return view('modules.invoice_payment_statuses.create', compact('preferences', 'ips'));
    }

    public function store(Request $request)
    {
        $obj = new InvoicePaymentStatus();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {
        $obj = InvoicePaymentStatus::find($request->id);
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {
           if(!checkPersonPermission('list_invoice_payment_statuses_13')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();

        return view('modules.invoice_payment_statuses.index', compact('preferences'));
    }

    public function edit($id)
    {
           if(!checkPersonPermission('update_invoice_payment_statuses_13')) {
               return ErrorMessage(403);
        }
        $obj = InvoicePaymentStatus::find($id);
        $preferences = UserPreferences::getPreferences();
        $ips = 'Invoice Payment Status';
        return view('modules.invoice_payment_statuses.update', compact('preferences', 'obj', 'ips'));
    }

    public function delete($id = false)
    {
           if(!checkPersonPermission('delete_invoice_payment_statuses_13')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = InvoicePaymentStatus::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid ID provided.',
        ]);
    }
}
