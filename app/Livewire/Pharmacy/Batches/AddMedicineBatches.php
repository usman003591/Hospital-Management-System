<?php

namespace App\Livewire\Pharmacy\Batches;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\PosMedicineBatch;

class AddMedicineBatches extends Component
{
    public $batch_number;
    public $expiry_date;
    public $quantity;
    public $medicine_minimum_quantity;
    public $packet_price;
    public $packet_items;
    public $barcode;
    public $manufacturing_date;
    public $medicine_batch_number;

    public $medicineId;
    public $medicineName;
    protected $listeners = ['refreshBatches' => 'loadInventoryBatchesList'];

    protected function generateUniqueBatchNumber()
    {
        do {
            $batchNumber = 'BATCH-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (PosMedicineBatch::where('batch_number', $batchNumber)->exists());
        return $batchNumber;
    }

    protected function generateUniqueBarcodeNumber()
    {
        do {
           $barcode = rand(1000000000000, 9999999999999);
        } while (PosMedicineBatch::where('barcode', $barcode)->exists());

        return $barcode;
    }

    protected $rules = [
        'expiry_date' => 'required|date',
        'medicine_batch_number' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'medicine_minimum_quantity' => 'required|integer|min:1',
        'packet_price' => 'required|numeric|min:0',
        'packet_items' => 'required|integer|min:1',
        'manufacturing_date' => 'required|date',
    ];

    public function mount($medicineId,$medicineName)
    {
        $this->medicineId = $medicineId;
        $this->medicineName = $medicineName;
        $this->batch_number = $this->generateUniqueBatchNumber();
        $this->barcode = $this->generateUniqueBarcodeNumber();
        $this->expiry_date = Carbon::today()->format('Y-m-d');
        $this->manufacturing_date = Carbon::today()->format('Y-m-d');
    }

    public function showModal()
    {
        $this->resetValidation();
        $this->dispatch('show-bootstrap-modal');
    }

    public function submit()
    {
        try {

        $this->validate();

        $medicineBatch = new PosMedicineBatch();
        $medicineBatch->medicine_id = $this->medicineId;
        $medicineBatch->medicine_batch_number = $this->medicine_batch_number;
        $medicineBatch->batch_number = $this->batch_number;
        $medicineBatch->barcode = $this->barcode;
        $medicineBatch->expiry_date = $this->expiry_date;
        $medicineBatch->manufacturing_date = $this->manufacturing_date;
        $medicineBatch->medicine_minimum_quantity = $this->medicine_minimum_quantity;
        $medicineBatch->packet_items = $this->packet_items;
        $medicineBatch->packet_price = $this->packet_price;
        $medicineBatch->selling_price = intval($this->packet_price / $this->packet_items);
        $medicineBatch->quantity = $this->quantity;
        $medicineBatch->created_by = auth()->user()->id;
        $medicineBatch->save();

        $this->reset(['medicineId','medicineName','batch_number','barcode','expiry_date','manufacturing_date','medicine_minimum_quantity','packet_price','packet_items','quantity']);
        // $this->dispatch('batchAdded');
        $this->dispatch('hide-bootstrap-modal');
        $this->dispatch('show-toast', type: 'success', message: 'Medicine batch added successfully!');
        $this->js('window.location.reload()');
        session()->flash('success', 'Medicine batch added successfully!');

        } catch (\Exception $e) {

        $message = $e->getMessage();
        $this->dispatch('show-toast', type: 'error', message: $message);

        }
    }

    public function render()
    {
        return view('livewire.pharmacy.batches.add-medicine-batches');
    }
}
