<?php

namespace App\Livewire\PatientDetails;

use Livewire\Component;
use App\Models\PatientsBriefHistory;

class BriefHistoryForm extends Component
{
    public $patientId;
    // public $clinicalDiagnosisId;
    public $description = '';
    public $showModal = false;

    protected $rules = [
        'description' => 'required|string|max:500',
        // 'clinicalDiagnosisId' => 'required|exists:clinical_diagnoses,id',
    ];

    public function create(){
        $this->reset(['description']);
        $this->showModal = true;
    }

    public function save(){
        $this->validate();

        PatientsBriefHistory::create([
            'description' => $this->description,
            'patient_id' => $this->patientId,
            'created_by' => auth()->id(),
        ]);

        // $this->dispatch('history-added');
        $this->showModal = false;
        session()->flash('success', 'Brief history added successfully.');
        return redirect()->route('patients.brief_histories', ['id' => $this->patientId]);
    }


    public function render()
    {
        return view('livewire.patient-details.brief-history-form');
    }
}
