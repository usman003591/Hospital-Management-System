<?php

namespace App\Livewire\InvestigationCustomFields;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InvestigationCustomField;

class AllInvestigationCustomFieldsListing extends Component
{
    use WithPagination;

    public $q = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q']);
        $this->resetPage();
    }

    public function render()
    {
        $data = InvestigationCustomField::query()
            ->select('investigations_custom_fields.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('investigations_custom_fields.name', 'ILIKE', "%{$this->q}%");
            })
            ->orderBy('investigations_custom_fields.created_at', 'desc')
            ->paginate(10);

        return view('livewire.investigation-custom-fields.all-investigation-custom-fields-listing', [
            'data' => $data,
            'page' => 'investigation_custom_fields',
        ]);
    }
}