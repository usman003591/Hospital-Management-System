<?php

namespace App\Livewire\Investigations;

use Livewire\Component;
use App\Models\LabInvestigationPrice;

class InvestigationPrices extends Component
{
    public $investigationId;
    public $investigationPrices = [];
    public $deleteId = null;
    protected $listeners = ['refreshMe' => 'loadInvestigationPrices'];

    public function mount($investigationId)
    {
        $this->investigationId = $investigationId;
        $this->loadInvestigationPrices();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $price = LabInvestigationPrice::find($this->deleteId);

        if ($price) {
            $price->delete();
            $this->dispatch('show-toast', type: 'success', message: 'Price deleted successfully!');
        } else {
            $this->dispatch('show-toast', type: 'error', message: 'Price not found!');
        }

        $this->deleteId = null;
        $this->dispatch('hide-delete-modal');
        $this->loadInvestigationPrices();
    }

    public function loadInvestigationPrices()
    {
        $this->investigationPrices = LabInvestigationPrice::join('investigations as investigation','investigation.id','=','lab_investigation_prices.investigation_id')
        ->where('investigation.id', $this->investigationId)
        ->select([
            'lab_investigation_prices.id',
            'lab_investigation_prices.price',
            'lab_investigation_prices.valid_from',
            'lab_investigation_prices.valid_to',
            'investigation.name as investigation_name',
            'lab_investigation_prices.created_at',
            'lab_investigation_prices.updated_at'
        ])
        ->orderByDesc('lab_investigation_prices.created_at')
        ->get();
    }

    public function render()
    {
        return view('livewire.investigations.investigation-prices', [
            'investigationPrices' => $this->investigationPrices,
        ]);
    }



}
