<?php

namespace App\Livewire\Departments;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Department; 

class AllDepartmentsListing extends Component
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
        $data = Department::query()
            ->select('departments.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('departments.name', 'ILIKE', "%{$this->q}%"); 
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('departments.status', $this->status);
            })
            ->orderBy('departments.created_at', 'desc')
            ->paginate(10);

        return view('livewire.departments.all-departments-listing', [
            'data' => $data,
            'page' => 'departments',
        ]);
    }
}