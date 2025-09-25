<?php

namespace App\Livewire\ClinicalDiagnosis\Opd;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Hospital;
use Livewire\WithPagination;
use App\Models\ClinicalDiagnosis;

class DoctorsDailyListing extends Component
{
    use WithPagination;
    public $q = '';
    public $status = 'pending';
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh' => '$refresh'];


    public function resetFilters()
    {
        $this->reset(['q', 'status']);
        $this->resetPage();
        //$this->dispatch('refresh'); // Make sure $listeners has 'refresh' => '$refresh'
        //$this->dispatch('force-page-reload');
        //$this->dispatch('reinit-js'); // To refresh JS

 // To r
    }

    public function render()
    {
        $doctor_id = getDoctorId();
        $today = Carbon::now()->format('Y-m-d') . '%';

        $data = ClinicalDiagnosis::leftJoin('patients as p', 'p.id', 'clinical_diagnoses.patient_id')
            ->leftJoin('cd_doctors as cdd', 'cdd.cd_id', 'clinical_diagnoses.id')
            ->leftJoin('doctors as d', 'cdd.doctor_id', 'd.id')
            ->leftJoin('hospitals as h', 'h.id', 'clinical_diagnoses.hospital_id')
            ->leftJoin('o_p_d_counters as counter', 'counter.id', 'clinical_diagnoses.counter_id')
            ->select([
                'clinical_diagnoses.*',
                'counter.name as counter_name',
                'p.name_of_patient as patient_name',
                'p.patient_mr_number as patient_mr_number',
                'cdd.start_date',
                'cdd.end_date',
                'd.doctor_name',
                'h.name as hospital_name',
            ])
            ->whereDate('clinical_diagnoses.created_at', $today)
            ->where('d.id', $doctor_id)
            ->when($this->q !== '', fn($query) =>
                $query->where('p.cell', 'iLIKE', "%{$this->q}%")
                    ->orWhere('p.name_of_patient', 'iLIKE', "%{$this->q}%")
                    ->orWhere('p.cnic_number', 'iLIKE', "%{$this->q}%")
                    ->orWhere('p.patient_mr_number', 'iLIKE', "%{$this->q}%")
                    ->orWhere('clinical_diagnoses.id', 'iLIKE', "%{$this->q}%")
                    ->orWhere('clinical_diagnoses.count', 'iLIKE', "%{$this->q}%")
            )
            ->when($this->status !== '', fn($query) =>
                $query->where('clinical_diagnoses.status', '=', (string) $this->status))
            ->orderBy('clinical_diagnoses.created_at', 'asc')
            ->paginate(10);

        return view('livewire.clinical-diagnosis.opd.doctors-daily-listing', [
            'data' => $data,
            'page' => 'clinical_diagnosis'
        ]);
    }
}
