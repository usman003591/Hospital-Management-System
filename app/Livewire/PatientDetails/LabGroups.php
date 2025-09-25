<?php

namespace App\Livewire\PatientDetails;

use App\Models\Patient;
use Livewire\Component;
use App\Models\LabGroup;
use App\Models\LabGroupTest;
use Livewire\WithPagination;
use App\Models\Investigations;
use App\Models\LabGroupTestResult;

class LabGroups extends Component
{
    use WithPagination;
    public $patientId;
    public $page = 'lab_groups';
    // public $labGroups = [];
    public $allGood;

    protected $paginationTheme = 'bootstrap';

    public function mount($patientId)
    {
        $this->patientId = $patientId;
        $this->loadLabGroups();
    }

    public function loadLabGroups()
    {
        $groups = LabGroup::leftJoin('doctors', 'lab_groups.doctor_id', '=', 'doctors.id')
            ->select('lab_groups.*', 'doctors.doctor_name as doctor_name')
            ->where('lab_groups.patient_id', $this->patientId)
            ->latest()
            ->paginate(10);

        foreach ($groups as $group) {
            // if ($group->status === 'pending') {
            // $lab_group_id = $group->id;
            // $lab_group_data = LabGroup::where('id', $lab_group_id)->first();
            // if (!$lab_group_data)
            //     continue;

            // $hospitalData = Hospital::where('id', $lab_group_data->hospital_id)->first();


            $tests = LabGroupTest::where('lab_group_id', $group->id)
                ->whereIn('status', ['collected', 'completed'])
                ->get();

            $processedTests = [];
            $allGood = true;

            if ($tests->isNotEmpty()) {
                foreach ($tests as $test) {
                    if (!is_null($test->generated_report_pdf_path)) {
                        $investigation = Investigations::find($test->investigation_id);
                        $results = LabGroupTestResult::where('lab_group_test_id', $test->id)->get();

                        $entry = new \stdClass();
                        $entry->testName = $investigation->name ?? null;
                        $entry->testResults = $results;
                        $processedTests[] = $entry;

                        if ($results->isEmpty()) {
                            $allGood = false;
                        }
                    } else {
                        $entry = new \stdClass();
                        $entry->testName = null;
                        $entry->testResults = [];
                        $processedTests[] = $entry;
                        $allGood = false;
                    }
                }
            } else {
                $allGood = false;
            }

            if (empty($processedTests)) {
                $allGood = false;
            }

            $group->setAttribute('processedTests', $processedTests);
            $group->setAttribute('allGood', $allGood);

            if ($allGood && $group->status === 'pending') {
                $group->status = 'completed';
                $group->save();
            }
            // } elseif ($group->status === 'completed') {

            //     $allGood = true;
            //     $group->allGood = $allGood;

            // }
        }

        return $groups;
    }

    public function render()
    {
        return view('livewire.patient-details.lab-groups', [
            'labGroups' => $this->loadLabGroups(), // ✅ Pass paginated result to view
        ]);
    }
}
