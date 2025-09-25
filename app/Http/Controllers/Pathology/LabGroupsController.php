<?php

namespace App\Http\Controllers\Pathology;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\LabGroup;
use Illuminate\Http\Request;
use App\Models\Investigations;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class LabGroupsController extends Controller
{
    public function fetchSpecificLabGroups(Request $request)
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $page = 'lab_groups';
        $key = 'lab_groups';

        if ($request->ajax()) {
            $query = LabGroup::leftJoin('patients as p', 'p.id', '=', 'lab_groups.patient_id')
                ->select([
                    'lab_groups.id',
                    'lab_groups.lab_group_number',
                    'lab_groups.status',
                    'p.patient_mr_number',
                    'lab_groups.created_at',
                    'p.name_of_patient as patient_name'
                ])
                ->where('lab_groups.hospital_id', $hospital_id);

            return DataTables::of($query)
                ->editColumn('lab_group_number', function ($lab_group) {
                    return $lab_group->lab_group_number ?? '-';
                })
                ->editColumn('patient_name', function ($lab_group) {
                    return $lab_group->patient_name ?? '-';
                })

                ->editColumn('status', function ($lab_group) use ($page) {
                    $id = (int) $lab_group->id;
                    $status = $lab_group->status ?? '';

                    if (!checkPersonPermission('change_status_lab_groups_55')) {
                        return ucfirst($status);
                    }

                    $options = [
                        'pending' => ['label' => 'Pending', 'class' => 'btn btn-info'],
                        'completed' => ['label' => 'Completed', 'class' => 'btn btn-success'],
                        'cancelled' => ['label' => 'Cancelled', 'class' => 'btn btn-danger'],
                    ];

                    $html = '<select name="change_status" '
                        . 'style="width: 160px; height: 34px; padding:5px; border: 1px solid #ccc;" '
                        . 'data-id="' . $id . '" '
                        . 'class="change-status-' . $page . ' ' . getLabGroupStatus($status) . '" '
                        . 'id="change_status">';

                    foreach ($options as $value => $data) {
                        $selected = ($value === $status) ? 'selected' : '';
                        $class = $data['class'];
                        $label = $data['label'];
                        $html .= "<option value=\"$value\" class=\"$class\" $selected>$label</option>";
                    }

                    $html .= '</select>';

                    return $html;
                })

                ->editColumn('patient_mr_number', function ($lab_group) {
                    return $lab_group->patient_mr_number ?? '-';
                })
                ->editColumn('created_at', function ($lab_group) {
                    return $lab_group->created_at ?? '-';
                })
                ->filter(function ($query) use ($request) {
                    if ($search = $request->get('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->where('p.name_of_patient', 'ilike', "%{$search}%")
                                ->orWhere('p.patient_mr_number', 'ilike', "%{$search}%");
                        });
                    }
                })
                ->addColumn('action', function ($lab_group) use ($page) {
                    return view('modules.lab_groups.include.actions', compact('lab_group', 'page'))->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function create(Request $request)
    {
        if (!checkPersonPermission('create_lab_groups_55')) {
            return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $patients = Patient::getForSelect();
        $doctors = Doctor::getForSelect();
        $hospitals = Hospital::getActiveHospitals();
        $pathology = 2;
        $investigations = Investigations::getInvestigationsByTypeAndInHouseWithPrices($pathology);

        return view('modules.lab_groups.create', compact('preferences', 'patients', 'doctors', 'hospitals', 'investigations'));
    }

    public function edit($id)
    {
        if (!checkPersonPermission('update_lab_groups_55')) {
            return ErrorMessage(403);
        }
        $obj = LabGroup::find($id);
        $preferences = UserPreferences::getPreferences();
        $patients = Patient::getForSelect();
        $doctors = Doctor::getForSelect();
        $hospitals = Hospital::getActiveHospitals();
        $pathology = 2;
        $investigations = Investigations::getInvestigationsByTypeAndInHouseWithPrices($pathology);
        $selectedInvestigations = Investigations::getSelectedPathologyInvestigations($obj->id, $pathology);

        return view('modules.lab_groups.update', compact('preferences', 'obj', 'patients', 'doctors', 'hospitals', 'investigations', 'selectedInvestigations'));
    }

    public function add_lab_group(Request $request)
    {
        $obj = new LabGroup();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new LabGroup();
        return $obj->updateForm();
    }

    public function change_status(Request $request)
    {
        $status = $request->status;
        if (!checkPersonPermission('change_status_lab_groups_55')) {
            return ucfirst($status);
        }
        $id = $request->id;
        $data = LabGroup::changeStatus($id, $status);
        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    public function delete($id = false)
    {

        if (!checkPersonPermission('delete_lab_groups_55')) {
            return ErrorMessage(403);
        }
        if ($id) {
            $obj = LabGroup::find($id);
            return $obj->deleteObj();
        }
    }

    public function index(Request $request)
    {

        if (!checkPersonPermission('list_lab_groups_55')) {
            return ErrorMessage(403);
        }
        $d = LabGroup::getAll();
        $doctors = Doctor::getForSelect();

        $page = 'lab_groups';
        $data = $d['data'];
        $search = $d['search'];

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.lab_groups.include.list_partial', compact('data', 'page', 'search'))->render(),
            ]);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.lab_groups.index', compact('preferences', 'page', 'search', 'data', 'doctors'));
    }

    public function check_qr_code($lab_group_number)
    {
        try {

            $decrypted_lab_group_number = decrypt($lab_group_number);
            $lab_group = LabGroup::where('lab_group_number', $decrypted_lab_group_number)->first();
            $userRoleId = auth()->user()->role_id;

            if (!$lab_group) {
                 return ErrorMessage(403);
            }

            if ($userRoleId == 3) {
                return redirect()->route('lab_groups.download_result', $lab_group->id);
            } else {
                return redirect()->route('lab_groups.lab_tests', $lab_group->id);
            }

        } catch (\Exception $e) {
                 return ErrorMessage(403);
        }
    }

}
