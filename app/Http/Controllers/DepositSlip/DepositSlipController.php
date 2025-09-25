<?php

namespace App\Http\Controllers\DepositSlip;

use App\Models\Patient;
use App\Models\Hospital;
use App\Models\DepositSlip;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class DepositSlipController extends Controller
{
    public function fetchSpecificDepositSlips(Request $request)
    {
    $preferences = UserPreferences::getPreferences();
    $hospital_id = $preferences['preference']['hospital_id'];
    $page = 'deposit_slips';

    $query = DepositSlip::leftJoin('users as u', 'u.id', '=', 'deposit_slips.user_id')
            ->leftJoin('hospitals as h', 'h.id', '=', 'deposit_slips.hospital_id')
            ->select([
                'deposit_slips.*',
                'u.name as user_name',
                'h.name as hospital_name'
            ])
        ->where('deposit_slips.hospital_id', $hospital_id);

            return DataTables::of($query)
              ->editColumn('deposit_slip_number', function ($slip) {
                return $slip->deposit_slip_number ?? '-';
            })
            ->editColumn('user_name', function ($slip) {
                return $slip->user_name ?? '-';
            })
            ->editColumn('hospital_name', function ($slip) {
                return $slip->hospital_name ?? '-';
            })
            ->editColumn('amount_in_figures', function ($slip) {
                return $slip->amount_in_figures ?? '-';
            })
            ->editColumn('date_issued', function ($slip) {
                return $slip->date_issued ?? '-';
            })
            ->editColumn('counter_number', function ($slip) {
                return $slip->counter_number ?? '-';
            })

            ->editColumn('payment_purpose', function ($slip) {
                return $slip->payment_purpose ?? '-';
            })

             ->filter(function ($query) use ($request) {
                if ($search = $request->get('search')['value']) {
                    $query->where(function ($q) use ($search) {
                        $q->where('u.name', 'ilike', "%{$search}%");
                        $q->orwhere('deposit_slip_number', 'ilike', "%{$search}%");


                    });
                }
            })
           ->addColumn('action', function ($slip) use ($page) {
            return view('modules.deposit_slips.include.actions', compact('slip', 'page'))->render();
            })
           ->rawColumns(['action'])
           ->make(true);
}
    public function index(Request $request)
    {
        $preferences = UserPreferences::getPreferences();
        return view('modules.deposit_slips.index', compact('preferences'));
    }

    public function create()
    {
         if(!checkPersonPermission('create_deposit_slips_section_51')) {
               return ErrorMessage(403);
        }
        $users = User::getForSelect();
        $hospitals = Hospital::getActiveHospitals();
        // $hospitals = Hospital::getForSelect();
        $preferences = UserPreferences::getPreferences();

        return view('modules.deposit_slips.create', compact('preferences', 'users', 'hospitals'));
    }

    public function store(Request $request)
    {
        $obj = new DepositSlip();
        return $obj->addForm($request);
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_deposit_slips_section_51')) {
               return ErrorMessage(403);
        }
        $obj = DepositSlip::find($id);
        $users = User::getForSelect();
        // $hospitals = Hospital::getForSelect();
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();

        return view('modules.deposit_slips.update', compact('preferences', 'obj', 'users', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $obj = DepositSlip::findOrFail($id);
        return $obj->updateForm($request);
    }

    public function delete($id)
    {
         if(!checkPersonPermission('delete_deposit_slips_section_51')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = DepositSlip::find($id);
            return $obj->deleteObj();
        }
    }

    public function downloadSlip($id)
    {
         if(!checkPersonPermission('download_deposit_slips_section_51')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = new DepositSlip();
            return $obj->downloadPDF($id);
        }
    }
}
