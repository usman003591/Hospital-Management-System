<?php

namespace App\Livewire\Pharmacy\Batches;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Medicines;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\PosMedicineBatch;
use App\Models\PosMedicineInventory;

class BatchesListing extends Component
{
    use WithPagination;
    public $medicineId;
    public $medicineName;

    public $medicineBatches = [];

    public $deleteId = null;
    public $editId = null;
    public $q = '';

    public function updating($name, $value)
    {
        $this->resetPage();
    }
    protected $listeners = ['batchAdded' => '$refresh', 'batchUpdated' => '$refresh'];
    public function resetFilters()
    {
        $this->reset(['q']);
        $this->resetPage();
    }

    public function openEditModel ($id) {
        $this->editId = $id;
        $this->dispatch('show-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('show-delete-modal');
    }

    public function mount($medicineId, $medicineName)
    {
        $this->medicineId = $medicineId;
        $this->medicineName = $medicineName;
        $this->loadInventoryBatchesList();
    }

    public function delete()
    {
        $batch = PosMedicineBatch::find($this->deleteId);
        if ($batch) {
            $batch->delete();
            $this->dispatch('show-toast', type: 'success', message: 'Batch deleted successfully!');
        } else {
            $this->dispatch('show-toast', type: 'error', message: 'Batch not found!');
        }

        $this->deleteId = null;
        $this->dispatch('hide-delete-modal');
        $this->loadInventoryBatchesList();
    }


    public function reCalculateTotalInventory () {

              $data = PosMedicineBatch::join(
                'medicines as medicine',
                'medicine.id',
                '=',
                'pos_medicine_batches.medicine_id'
            )
            ->where('medicine_id', $this->medicineId)
            ->where('pos_medicine_batches.expiry_date','>=',date('Y-m-d'))
            ->select('pos_medicine_batches.*', 'medicine.name as medicine_name')
            ->when($this->q !== '', function ($query) {
                $query->where(function($sub) {
                    $sub->where('pos_medicine_batches.batch_number', 'ILIKE', "%{$this->q}%")
                        ->orWhere('pos_medicine_batches.barcode', 'ILIKE', "%{$this->q}%");
                });
            })
            ->get();

            $total_quantity = 0;
            foreach ($data as $d) {
                $total_quantity += $d->quantity;
            }

            $medicine = PosMedicineInventory::where('medicine_id',$this->medicineId)->first();
            $medicine->quantity = $total_quantity;
            $medicine->updated_by = auth()->user()->id;
            $medicine->save();
    }

    public function batchesQuery()
    {
            $this->reCalculateTotalInventory();
            return PosMedicineBatch::join(
                'medicines as medicine',
                'medicine.id',
                '=',
                'pos_medicine_batches.medicine_id'
            )
            ->where('medicine_id', $this->medicineId)
            ->select('pos_medicine_batches.*', 'medicine.name as medicine_name')
            ->when($this->q !== '', function ($query) {
                $query->where(function($sub) {
                    $sub->where('pos_medicine_batches.batch_number', 'ILIKE', "%{$this->q}%")
                        ->orWhere('pos_medicine_batches.barcode', 'ILIKE', "%{$this->q}%");
                });
            });
        }

    public function loadInventoryBatchesList()
    {
        return $this->batchesQuery()->paginate(10);
    }

    public function render()
    {
        $batches = $this->loadInventoryBatchesList();
        return view('livewire.pharmacy.batches.batches-listing', compact('batches'));
    }
}
