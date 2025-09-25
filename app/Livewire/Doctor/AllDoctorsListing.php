<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use Livewire\Component;
use App\Models\Hospital;
use App\Models\Department;
use Livewire\WithPagination;

class AllDoctorsListing extends Component
{
    use WithPagination;
    public $q = '';
    public $status = '';
    public $department = '';
    public $hospital = '';
    protected $paginationTheme = 'bootstrap'; // or tailwind

    public function updating($name, $value)      //  ← two parameters
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'status', 'department','hospital']);
        $this->resetPage();
    }

    public function render()
    {
        $departments = Department::getActiveDepartments();
        $hospitals = Hospital::getActiveHospitals();

        $data = Doctor::query()
            ->join('departments as d', 'd.id', '=', 'doctors.department_id')
            ->join('users as user','user.id','doctors.user_id')
            ->join('hospitals as hospital','hospital.id','user.hospital_id')
            ->select('doctors.*', 'd.name as department_name')
            // ->where('hospital.id',$hospital_id)
            ->when($this->q !== '', fn ($query) =>
                $query->where('doctors.doctor_name', 'ILIKE', "%{$this->q}%"))
            ->when($this->department !== '', fn ($query) =>
                $query->where('doctors.department_id', $this->department))
           ->when( $this->status !== '', fn($query) =>
                 $query->where('doctors.status', (int) $this->status))
            ->when( $this->hospital !== '', fn($query) =>
                 $query->where('user.hospital_id', (int) $this->hospital))->latest()
            ->paginate(10);

            return view('livewire.doctor.all-doctors-listing', [
                'departments' => $departments,
                'data'        => $data,
                'page'        => 'doctors',
                'hospitals'   => $hospitals
            ]);
    }
}
