<?php

namespace App\Livewire\Investigations;

use App\Models\LabInvestigationPrice;
use Livewire\Component;

class AddInvestigationPrice extends Component
{
    public $price;
    public $valid_from;
    public $valid_to;
    public $investigationId;
    public $investigationName;

    protected $listeners = ['refreshPrices' => 'loadInvestigationPrices'];

    protected $rules = [
        'price' => 'required|numeric|min:1',
        'valid_from' => 'required',
        'valid_to' => 'required',
    ];

    public function mount($investigationId,$investigationName)
    {
        $this->investigationId = $investigationId;
        $this->investigationName = $investigationName;
    }

    public function showModal()
    {
        $this->resetValidation();
        $this->dispatch('show-bootstrap-modal');
    }

    public function submit()
    {
        $this->validate();

        $investigationPriceData = [
            'investigation_id' => $this->investigationId,
            'price' => $this->price,
            'valid_from' => $this->valid_from,
            'valid_to' => $this->valid_to,
            'created_by' => auth()->user()->id
        ];

        $obj = LabInvestigationPrice::createInvestigationPrice($investigationPriceData);
        $this->reset(['price','valid_from','valid_to']);
        $this->dispatch('refreshMe');

        $this->dispatch('hide-bootstrap-modal');
        $this->dispatch('show-toast', type: 'success', message: 'Investigation Price added successfully!');
        session()->flash('success', 'Investigation Price added successfully!');
    }

    public function render()
    {
        return view('livewire.investigations.add-investigation-price');
    }
}
