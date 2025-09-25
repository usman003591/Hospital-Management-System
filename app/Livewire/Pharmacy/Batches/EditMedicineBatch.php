<?php

namespace App\Livewire\Pharmacy\Batches;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\PosMedicineBatch;

class EditMedicineBatch extends Component
{
    public $medicineBatchId;
    public $medicineId;
    public $medicineName;

    public $medicine_batch_number;

    public $batch_number;
    public $expiry_date;
    public $manufacturing_date;
    public $quantity;
    public $medicine_minimum_quantity;
    public $packet_price;
    public $packet_items;
    public $barcode;
    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }


    protected $listeners = ['openEditBatch' => 'loadBatch'];

    protected $rules = [
        'expiry_date' => 'required|date',
        'medicine_batch_number' => 'required|string',
        'manufacturing_date' => 'required|date',
        'quantity' => 'required|integer|min:1',
        'medicine_minimum_quantity' => 'required|integer|min:1',
        'packet_price' => 'required|numeric|min:0',
        'packet_items' => 'required|integer|min:1',
    ];

    public function mount($batchId, $medicineId, $medicineName)
    {
        $this->medicineBatchId = $batchId;
        $this->medicineId = $medicineId;
        $this->medicineName = $medicineName;


        $this->loadBatch($batchId);
    }

    public function loadBatch($medicineBatchId)
    {
        $this->resetValidation();
        $batch = PosMedicineBatch::findOrFail($medicineBatchId);
        $this->batch_number = $batch->batch_number;
        $this->expiry_date = Carbon::parse($batch->expiry_date)->format('Y-m-d');
        $this->manufacturing_date = Carbon::parse($batch->manufacturing_date)->format('Y-m-d');
        $this->quantity = $batch->quantity;
        $this->medicine_minimum_quantity = $batch->medicine_minimum_quantity;
        $this->packet_price = $batch->packet_price;
        $this->packet_items = intval($batch->packet_items);
        $this->barcode = $batch->barcode;
        $this->medicine_batch_number = $batch->medicine_batch_number;
    }

    public function update()
    {
        try {

            $this->validate();

            $batch = PosMedicineBatch::findOrFail($this->medicineBatchId);

            $batch->update([
                'batch_number' => $this->batch_number,
                'expiry_date' => Carbon::parse($this->expiry_date),
                'manufacturing_date' => Carbon::parse($this->manufacturing_date),
                'quantity' => $this->quantity,
                'medicine_batch_number' => $this->medicine_batch_number,
                'medicine_minimum_quantity' => $this->medicine_minimum_quantity,
                'packet_price' => $this->packet_price,
                'packet_items' => $this->packet_items,
                'barcode' => $this->barcode,
                'selling_price' => intval($this->packet_price / $this->packet_items),
                'updated_by' => auth()->id(),
            ]);

            $this->closeModal();
            $this->dispatch('show-toast', type: 'success', message: 'Medicine batch updated successfully!');
            $this->dispatch('reload-page');


        } catch (\Exception $e) {

            $message = $e->getMessage();
            $this->dispatch('show-toast', type: 'error', message: $message);

        }
    }

    public function render()
    {
        return view('livewire.pharmacy.batches.edit-medicine-batch');
    }
}
