<?php

namespace App\Http\Controllers\Pharmacy;

use Carbon\Carbon;
use App\Models\Hospital;
use App\Models\Medicines;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PosMedicineBatch;
use App\Http\Controllers\Controller;
use App\Models\PosMedicineInventory;

class PharmacyInventoryBatchesController extends Controller
{
    public function index($medicine_id)
    {
        $medicine = Medicines::find($medicine_id);
        $preferences = UserPreferences::getPreferences();
        $inventory = PosMedicineInventory::where('medicine_id', $medicine_id)->first();

        return view('modules.pharmacy.inventory_management.batches.index', compact('medicine', 'preferences', 'inventory'));
    }

    public function downloadBarCode ($medicine_id, $batch_id) {

        $batch = PosMedicineBatch::find(intval($batch_id));
        $medicine = Medicines::find(intval($medicine_id));
        $preferences = UserPreferences::getPreferences();

        $hospital_id = $preferences['preference']['hospital_id'];
        $hospital = Hospital::find($hospital_id);

        $data = [
            'barcodeText' => $batch->barcode,
            'logo' => $hospital->logo,
            'medicine_name' => $medicine->name,
            'price' => $batch->selling_price,
            'expiry_date' => Carbon::parse($batch->expiry_date)
        ];

        $pdf = Pdf::loadView('documents.pos.batches_barcode', $data);
        $pdf->setPaper([0, 0, 72, 144], 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        return $pdf->stream('barcode-label.pdf');
    }

}
