<?php

namespace App\Livewire\MedicineCategories;

use App\Models\MedicineCategory;
use Livewire\Component;
use Livewire\WithPagination;

class AllMedicineCategoriesListing extends Component
{
    use WithPagination;

    public $q = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

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
        $data = MedicineCategory::query()
            ->select('pos_medicine_categories.*')
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('pos_medicine_categories.name', 'ILIKE', "%{$this->q}%");
                });
            })
            ->when($this->status !== '', fn ($query) =>
                $query->where('pos_medicine_categories.status', $this->status))
            ->orderBy('pos_medicine_categories.created_at', 'desc') // Latest records at top
            ->paginate(10);

        return view('livewire.medicine_categories.all-medicine-categories-listing', [
            'data' => $data,
            'page' => 'medicine_categories'
        ]);
    }
}