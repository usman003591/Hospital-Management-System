<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Medicines;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\PosMedicineInventory;
use App\Models\PosMedicineInventoryStatus;

class PharmacyInventoryController extends Controller
{
    public function index()
    {
        $preferences = UserPreferences::getPreferences();
        return view('modules.pharmacy.inventory_management.index', compact('preferences'));
    }

    public function create(Request $request)
    {
        $medicines = Medicines::where('is_in_house', 1)->get();
        $preferences = UserPreferences::getPreferences();
        $inventory_statuses = PosMedicineInventoryStatus::getActiveMedicineInventoryStatuses();

        return view('modules.pharmacy.inventory_management.create', compact('preferences', 'medicines', 'inventory_statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'medicine_id' => 'required|exists:medicines,id',
            'reorder_number' => 'required|integer|min:1|max_digits:9',
            'medicine_inventory_status_id' => 'required|exists:pos_medicine_inventory_statuses,id',
        ]);

        $inventory = PosMedicineInventory::withTrashed()
        ->where('medicine_id', $validatedData['medicine_id'])
        ->first();

        if ($inventory) {
            if ($inventory->trashed()) {
                // Restore if soft deleted
                $inventory->restore();
            }

            $inventory = PosMedicineInventory::updateOrCreate([
                'medicine_id' => $validatedData['medicine_id'],
                'hospital_id' => $validatedData['hospital_id']
            ],[
                'medicine_inventory_status_id' => $validatedData['medicine_inventory_status_id'],
                'reorder_number' => $validatedData['reorder_number'],
                'quantity' => 0,
                'created_by' => auth()->user()->id
            ]);

        } else {

            $inventory = PosMedicineInventory::updateOrCreate([
            'medicine_id' => $validatedData['medicine_id'],
            'hospital_id' => $validatedData['hospital_id']
            ],[
                'medicine_inventory_status_id' => $validatedData['medicine_inventory_status_id'],
                'reorder_number' => $validatedData['reorder_number'],
                'quantity' => 0,
                'created_by' => auth()->user()->id
            ]);

        }

        return redirect()->route('pharmacy.list_pharmacy_inventory')->with('success', 'Medicine inventory created successfully.');
    }

    public function edit($inventory_id)
    {
        $medicines = Medicines::where('is_in_house', 1)->get();
        $preferences = UserPreferences::getPreferences();
        $inventory_statuses = PosMedicineInventoryStatus::getActiveMedicineInventoryStatuses();
        $obj = PosMedicineInventory::findOrFail($inventory_id);

        return view('modules.pharmacy.inventory_management.update', compact('obj', 'medicines', 'preferences', 'inventory_statuses'));
    }

    public function update (Request $request, $inventory_id) {

        $validatedData = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'medicine_id' => 'required|exists:medicines,id',
            'reorder_number' => 'required|integer|min:1|max_digits:9',
            'medicine_inventory_status_id' => 'required|exists:pos_medicine_inventory_statuses,id',
        ]);

        $inventory = PosMedicineInventory::findOrFail($inventory_id);
        $inventory->update($validatedData);

        return redirect()->route('pharmacy.list_pharmacy_inventory')->with('success', 'Medicine inventory updated successfully.');
    }

    public function destroy($id = false)
    {
        if ($id) {
            $obj = PosMedicineInventory::find($id);
            return $obj->deleteObj();
        }
    }

}
