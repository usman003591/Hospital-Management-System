<?php

namespace App\Livewire\PatientDetails;

use Livewire\Component;
use App\Models\PatientsBriefHistory;

class BriefHistoryList extends Component
{
    public $patientId;
    public $briefHistories = [];

    public function mount($patientId)
    {
        $this->patientId = $patientId;
        $this->loadBriefHistories();
    }

    public function loadBriefHistories()
    {
        // Fetch brief histories for the patient
        $this->briefHistories = PatientsBriefHistory::where('patient_id', $this->patientId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.patient-details.brief-history-list', [
            'briefHistories' => $this->briefHistories,
        ]);
    }
}
