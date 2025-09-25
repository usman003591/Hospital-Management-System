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

class LabGroupTests extends Component
{
    use WithPagination;

    public $lab_group_id;

    public function mount($lab_group_id)
    {
        $this->lab_group_id = $lab_group_id;
    }
    public function render()
    {
        $preferences = UserPreferences::getPreferences();
        $obj = LabGroup::find($this->lab_group_id);
        $patient = Patient::find($obj->patient_id);
        $lab_group_data = LabGroup::getLabGroupDetailsById($this->lab_group_id);

        $lab_group_tests =  LabGroupTest::join('investigations as inv','inv.id','lab_group_tests.investigation_id')
                ->join('lab_groups as lg','lg.id','lab_group_tests.lab_group_id')
                ->select([
                    'inv.name as name',
                    'inv.description as description',
                    'lg.lab_group_number as lab_group_number',
                    'lab_group_tests.*'
                ])
                ->where('lab_group_id',$this->lab_group_id)
                ->orderby('lab_group_tests.created_at', 'desc')
                ->paginate(10);

        $lab_group_stats = LabGroupTest::getLabGroupTestStats($this->lab_group_id);

        $count =  LabGroupTest::join('investigations as inv','inv.id','lab_group_tests.investigation_id')
        ->join('lab_groups as lg','lg.id','lab_group_tests.lab_group_id')
        ->select([
            'inv.name as name',
            'inv.description as description',
            'lg.lab_group_number as lab_group_number',
            'lab_group_tests.*'
        ])
        ->where('lab_group_id',$this->lab_group_id)
        ->orderby('lab_group_tests.created_at', 'desc')
        ->count();


        // $count = count($lab_group_tests_count);
        $investigations = Investigations::getInvestigationsByTypeAndInHouse(2);

        return view('livewire.pathology.lab-group-tests',compact(
            'preferences',
            'obj',
            'patient',
            'lab_group_data',
            'lab_group_tests',
            'lab_group_stats',
            'count',
            'investigations'
        ));
    }
}
