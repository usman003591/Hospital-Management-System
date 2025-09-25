<?php

namespace App\Livewire\AdmitPatients;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AdmitPatients;
use App\Models\Department; // Assume this model exists
use App\Models\Ward; // Assume this model exists

class AllAdmitPatientsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $department = '';
    public $ward = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'department' => ['except' => ''],
        'ward' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'department', 'ward', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $data = AdmitPatients::query()
            ->select('admit_patients.*')
            ->join('wards', 'admit_patients.ward_id', '=', 'wards.id')
            ->join('rooms', 'admit_patients.room_id', '=', 'rooms.id')
            ->join('beds', 'admit_patients.bed_id', '=', 'beds.id')
            ->join('departments', 'admit_patients.department_id', '=', 'departments.id')
            ->when($this->q !== '', function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->where('wards.ward_name', 'ILIKE', "%{$this->q}%")
                                ->orWhere('rooms.room_number', 'ILIKE', "%{$this->q}%")
                                ->orWhere('beds.bed_number', 'ILIKE', "%{$this->q}%");
                    });
                })

            ->when($this->department !== '', function ($query) {
                return $query->where('admit_patients.department_id', $this->department);
            })
            ->when($this->ward !== '', function ($query) {
                return $query->where('admit_patients.ward_id', $this->ward);
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('admit_patients.status', $this->status);
            })
            ->orderBy('admit_patients.created_at', 'desc')
            ->paginate(10);

        // Fetch all departments for the dropdown
        $departments = Department::all()->pluck('name', 'id')->toArray();
        $wards = Ward::all()->pluck('ward_name', 'id')->toArray();

        // dd($departments);

        return view('livewire.admit_patients.all-admit-patients-listing', [
            'data' => $data,
            'page' => 'admit_patients',
            'departments' => $departments,
            'wards' => $wards,
        ]);
    }
}