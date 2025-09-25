<?php

namespace App\Livewire\Pathology;

use stdClass;
use App\Models\Invoice;
use App\Models\Patient;
use Livewire\Component;
use App\Models\Hospital;
use App\Models\LabGroup;
use App\Models\LabGroupTest;
use Livewire\WithPagination;
use App\Models\Investigations;
use App\Models\UserPreferences;
use App\Models\LabGroupTestResult;
use Illuminate\Support\Facades\File;

class LabGroups extends Component
{
    use WithPagination;
    public $q = '';
    public $hospital_id = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'hospital_id', 'status']);
        $this->resetPage();
    }

    public function render()
    {

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $data = LabGroup::query()
            ->join('patients as patient', 'patient.id', 'lab_groups.patient_id')
            ->join('hospitals as h', 'h.id', 'lab_groups.hospital_id')
            ->leftjoin('doctors as d', 'd.id', 'lab_groups.doctor_id')
            ->leftjoin('clinical_diagnoses as cd', 'cd.id', 'lab_groups.clinical_diagnosis_id')
            ->select([
                'patient.name_of_patient as patient_name',
                'patient.cnic_number as cnic_number',
                'patient.patient_mr_number as patient_mr_number',
                'h.name as hospital_name',
                'd.doctor_name as doctor_name',
                'lab_groups.*'
            ])
            ->where('h.id', $hospital_id)
            ->when(
                $this->q !== '',
                fn($query) =>
                $query->where('patient.name_of_patient', 'ILIKE', "%{$this->q}%")
                    ->orWhere('patient.patient_mr_number', 'ILIKE', value: "%{$this->q}%")
                    ->orWhere('patient.cell', 'ILIKE', value: "%{$this->q}%")
                    ->orWhere('patient.cnic_number', 'ILIKE', value: "%{$this->q}%")
                    ->orWhere('lab_groups.lab_group_number', 'ILIKE', value: "%{$this->q}%")
            )
            ->when($this->status !== '', fn($query) =>
                $query->where('lab_groups.status', (int) $this->status))
            ->orderBy('lab_groups.created_at', 'desc')
            ->paginate(10);


        foreach ($data as $d) {
            if ($d->status === 'pending') {

                $lab_group_id = $d->id;
                $lab_group_data = LabGroup::where('id', $lab_group_id)->first();
                if (!$lab_group_data)
                    continue;

                $hospitalData = Hospital::where('id', $lab_group_data->hospital_id)->first();
                $patientData = Patient::where('id', $lab_group_data->patient_id)->first();
                $tests = LabGroupTest::where('lab_group_id', $lab_group_id)
                    ->whereIn('status', ['completed', 'collected'])
                    ->get();

                $processedTests = [];
                $allGood        = true;

                if ($tests->isNotEmpty()) {
                    foreach ($tests as $test) {
                        if (!is_null($test->generated_report_pdf_path)) {

                            $investigation = Investigations::where('id', $test->investigation_id)->first();
                            $testResults = LabGroupTestResult::where('lab_group_test_id', $test->id)->get();

                            if ($testResults->isNotEmpty()) {

                                $StdObj = new stdClass();
                                $StdObj->testName = $investigation->name ?? null;
                                $StdObj->testResults = $testResults;
                                $processedTests[] = $StdObj;
                                $allGood = true;

                            } else {

                                $StdObj = new stdClass();
                                $StdObj->testName = $investigation->name ?? null;
                                $StdObj->testResults = [];
                                $processedTests[] = $StdObj;
                                $allGood = false;
                            }
                        }
                    }
                }

                if (empty($processedTests)) {
                    $allGood = false;
                }

                $d->processedData = [
                    'hospitalData' => $hospitalData,
                    'patientData' => $patientData,
                    'labGroupData' => $lab_group_data,
                    'tests' => $tests,
                    'processedTests' => $processedTests,
                    'allGood' => $allGood,
                ];

                $d->processedTests = $processedTests;
                $d->allGood        = $allGood;

                if ($allGood) {

                    $lab_group_data->status = 'completed';
                    $lab_group_data->save();

                }

            } elseif ($d->status === 'completed') {

                $allGood = true;
                $d->allGood = $allGood;

            }
        }



        return view('livewire.pathology.lab-groups', [
            'data' => $data,
            'page' => 'lab_groups',
        ]);
    }
}
