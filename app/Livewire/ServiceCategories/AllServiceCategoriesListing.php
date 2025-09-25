<?php

namespace App\Livewire\ServiceCategories;

use Livewire\Component;
use App\Models\Hospital;
use Livewire\WithPagination;
use App\Models\ServiceCategory;

class AllServiceCategoriesListing extends Component
{
    use WithPagination;

    public $q = '';
    public $status = '';
    public $parent_id = '';
    public $hospital = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'status' => ['except' => ''],
        'parent_id' => ['except' => ''],
        'hospital' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'status', 'parent_id', 'hospital']);
        $this->resetPage();
    }

    public function render()
    {
        $hospitals = Hospital::getActiveHospitals();

        $data = ServiceCategory::query()
            ->select(
                'service_categories.*',
                'hospitals.name as hospital_name',
                'serviceCat.service_name as parent_name',
                'serviceCat.id as parent_id'
            )
            ->join('hospitals', 'hospitals.id', '=', 'service_categories.hospital_id')
            ->leftJoin('service_categories as serviceCat', 'serviceCat.id', '=', 'service_categories.parent_id')
            ->withoutTrashed()
            ->when($this->q !== '', function ($query) {
                return $query->where('service_categories.service_name', 'ILIKE', "%{$this->q}%");
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('service_categories.status', $this->status);
            })
            ->when($this->parent_id !== '', function ($query) {
                if ($this->parent_id === '-1') {
                    return $query->where(function ($q) {
                        return $q->where('service_categories.parent_id', 0)
                                ->orWhereNull('service_categories.parent_id');
                    });
                }
                if ($this->parent_id === '0') {
                    return $query->where('service_categories.parent_id', 0); 
                }
                return $query->where('service_categories.parent_id', $this->parent_id);
            })
            ->when($this->hospital !== '', function ($query) {
                return $query->where('service_categories.hospital_id', (int) $this->hospital);
            })
            ->orderBy('service_categories.created_at', 'desc')
            ->paginate(10);

        $parents = ServiceCategory::where('parent_id', 0)->orWhereNull('parent_id')->whereNull('deleted_at')->pluck('service_name', 'id');

        return view('livewire.service_categories.all-service-categories-listing', [
            'data' => $data,
            'page' => 'service_categories',
            'parents' => $parents,
            'hospitals' => $hospitals
        ]);
    }
}