<?php

namespace App\Livewire\Prescriptions;


use Livewire\Component;
use App\Models\Hospital;
use App\Models\Prescription;
use Livewire\WithPagination;
use App\Models\UserPreferences;


class PrescriptionsListing extends Component
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
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $data = Prescription::query()
            ->join('hospitals as h', 'h.id', '=', 'prescriptions.hospital_id')
            ->join('patients as p', 'p.id', '=', 'prescriptions.patient_id')
            ->join('doctors as d', 'd.id', '=', 'prescriptions.doctor_id')
            ->leftJoin('o_p_d_counters as c', 'c.id', '=', 'prescriptions.counter_id')
            ->select(
                'prescriptions.*',
                'h.name as hospital_name',
                'p.name_of_patient as patient_name',
                'd.doctor_name as doctor_name',
                'c.name as counter_name'
            )
            ->where('h.id',$hospital_id)
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('p.name_of_patient', 'ILIKE', "%{$this->q}%")
                            ->orWhere('p.cnic_number', 'ILIKE', "%{$this->q}%")
                            ->orWhere('p.patient_mr_number', 'ILIKE', "%{$this->q}%");
                });
            })
            ->when($this->status !== '', fn ($query) =>
                $query->where('prescriptions.status', $this->status))
            ->orderBy('prescriptions.created_at', 'desc')
            ->paginate(10);

        return view('livewire.prescriptions.prescriptions-listing', [
            'data' => $data,
            'page' => 'prescriptions',
            'hospitals' => $hospitals
        ]);
    }




}
