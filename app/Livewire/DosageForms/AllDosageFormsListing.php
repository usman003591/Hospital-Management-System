<?php

namespace App\Livewire\DosageForms;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DosageForm;

class AllDosageFormsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $data = DosageForm::query()
            ->select('dosage_forms.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('dosage_forms.name', 'ILIKE', "%{$this->q}%");
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('dosage_forms.status', $this->status);
            })
            ->orderBy('dosage_forms.created_at', 'desc')
            ->paginate(10);

        return view('livewire.dosage-forms.all-dosage-forms-listing', [
            'data' => $data,
            'page' => 'dosage_forms',
        ]);
    }
}
