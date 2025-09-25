<?php

namespace App\Models;


use Response;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Department;
use App\Models\UserPreferences;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'prescriptions';

    protected $fillable = [
        'patient_id',
        'hospital_id',
        'doctor_id',
        'date',
        'status',
        'counter_id',
        'token_number',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getPrescriptionsCount()
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        return self::where('hospital_id','=',$hospital_id)->count();
    }


    public function generateFromHtmlPlainPrescription ($id) {

        $prescription_data = Prescription::join('o_p_d_counters as opdc','opdc.id','prescriptions.counter_id')
        ->select(['prescriptions.*','opdc.name as counter_name'])
        ->where('prescriptions.id',$id)
        ->first();

        if ($prescription_data) {

            $patient_id = $prescription_data->patient_id;
            $doctor_id = $prescription_data->doctor_id;

            if ($patient_id && $doctor_id) {

                $patient_data = Patient::withTrashed()->find($patient_id);
                $doctor_data = Doctor::withTrashed()->find($doctor_id);
                $department_data = Department::find($doctor_data->department_id);
                $hospital = Hospital::find($prescription_data->hospital_id);

                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.prescriptions.plain_prescription', compact('patient_data', 'doctor_data','department_data','hospital','prescription_data'))
                ->setPaper('A4', 'landscape');

                return $pdf->stream('prescription.pdf');
            }
        }

    }

    public function generatePrescription($id)
    {
        $prescription_data = Prescription::find($id);

        if ($prescription_data) {

            $patient_id = $prescription_data->patient_id;
            $doctor_id = $prescription_data->doctor_id;

            if ($patient_id && $doctor_id) {

                $patient_data = Patient::withTrashed()->find($patient_id);
                $doctor_data = Doctor::withTrashed()->find($doctor_id);
                $department_data = Department::find($doctor_data->department_id);

                $template = null;

                if ($prescription_data->hospital_id == 1) {
                    $template = public_path() . "/documents/prescriptions/sirm_prescription.pdf";
                }

                if ($prescription_data->hospital_id == 2) {
                    $template = public_path() . "/documents/prescriptions/sch_prescription.pdf";
                }

                $output_prescription = null;
                $exsisting_prescription = null;

                if ($prescription_data->hospital_id == 1) {
                    $output_prescription = public_path('/documents/prescriptions/output_sirm_prescription.pdf');
                    $exsisting_prescription = public_path() . "/documents/prescriptions/sirm_prescription.pdf";
                }

                if ($prescription_data->hospital_id == 2) {
                    $output_prescription = public_path('/documents/prescriptions/output_sch_prescription.pdf');
                    $exsisting_prescription = public_path() . "/documents/prescriptions/sch_prescription.pdf";
                }

                $pdf = new \setasign\Fpdi\Fpdi();

                $pageCount = $pdf->setSourceFile($exsisting_prescription);
                $pageNo = 1;

                // for ($pageNo = 0; $pageNo <= $pageCount; $pageNo++) {

                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
                $pdf->SetFont('Helvetica', 'B', 10);

                if ($prescription_data->hospital_id == 1) {
                        //Setting up department name and doctor name
                        $pdf->SetXY(53, 63.5);
                        $pdf->Cell(0, 10, $department_data->name . ' / ' . $doctor_data->doctor_name);

                        $pdf->SetXY(35, 72);
                        $pdf->Cell(0, 10, $patient_data->name_of_patient);

                        $pdf->SetXY(129, 80);
                        $pdf->Cell(0, 10, $patient_data->age);

                        $pdf->SetXY(135, 72);
                        $pdf->Cell(0, 10, ucfirst($patient_data->gender));

                        $pdf->SetXY(171, 72);
                        $pdf->Cell(0, 10, getBasicDateFormat($prescription_data->date, 'd-m-Y'));

                        $pdf->SetXY(24, 80);
                        $pdf->Cell(0, 10, $patient_data->cnic_number);

                        $patient_category = str_replace("_", " ", $patient_data->patient_category);

                        $pdf->SetXY(171, 80);
                        $pdf->Cell(0, 10, ucfirst($patient_category));

                        $pdf->SetXY(80, 80);
                        $pdf->Cell(0, 10, $patient_data->patient_mr_number);
                }

                if ($prescription_data->hospital_id == 2) {

                        //Setting up department name and doctor name
                        $pdf->SetXY(53, 63.5);
                        $pdf->Cell(0, 10, $department_data->name . ' / ' . $doctor_data->doctor_name);

                        $pdf->SetXY(35, 72);
                        $pdf->Cell(0, 10, $patient_data->name_of_patient);

                        $pdf->SetXY(129, 80);
                        $pdf->Cell(0, 10, $patient_data->age);

                        $pdf->SetXY(135, 72);
                        $pdf->Cell(0, 10, ucfirst($patient_data->gender));

                        $pdf->SetXY(171, 72);
                        $pdf->Cell(0, 10, getBasicDateFormat($prescription_data->date, 'd-m-Y'));

                        $pdf->SetXY(24, 80);
                        $pdf->Cell(0, 10, $patient_data->cnic_number);

                        $patient_category = str_replace("_", " ", $patient_data->patient_category);

                        $pdf->SetXY(171, 80);
                        $pdf->Cell(0, 10, ucfirst($patient_category));

                        $pdf->SetXY(80, 80);
                        $pdf->Cell(0, 10, $patient_data->patient_mr_number);

                }

                $pdf->Output($output_prescription, 'F'); // Save to file

                return response()->file($output_prescription, [
                    'Content-Type' => 'application/pdf',
                ]);

            }
        }
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;
        $search['hospital'] = $request->has('hospital') ? $request->get('hospital') : false;

        $data = self::leftJoin('patients as p', 'p.id', '=', 'prescriptions.patient_id')
            ->leftjoin('hospitals as h', 'h.id', 'prescriptions.hospital_id')
            ->leftJoin('doctors as d', 'd.id', '=', 'prescriptions.doctor_id')
            ->leftjoin('o_p_d_counters as counter','counter.id', 'prescriptions.counter_id')
            ->select([
                'prescriptions.*',
                'counter.name as counter_name',
                'p.name_of_patient as patient_name',
                'h.name as hospital_name',
                'd.doctor_name as doctor_name'
            ]);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('p.name_of_patient', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('p.patient_mr_number', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('p.cnic_number', 'iLIKE', "%{$search['q']}%");
            });
        }

        if ($search['hospital']) {
            $data = $data->where('prescriptions.hospital_id', $search['hospital']);
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 'paid') {
                $data = $data->where('prescriptions.status', 'paid');
            } elseif ($search['status'] == 'unpaid') {
                $data = $data->where('prescriptions.status', 'unpaid');
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('prescriptions.created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'patient_id' => ['required'],
            'doctor_id' => ['required'],
            'hospital_id' => ['required'],
           // 'token_number' => ['required'],
        ],[
            'patient_id.required' => 'Patient is required',
            'doctor_id.required' => 'Doctor is required',
            'hospital_id.required' => 'Hospital is required',
        ]);

        $today = Carbon::today()->toDateString();
        // Get the last counter number for today
        $lastCounter = Prescription::where('date', $today)
            ->where('hospital_id', request('hospital_id'))
            ->where('counter_id', request('counter_id'))
            ->orderBy('token_number', 'desc')
            ->first();

        // Calculate the next counter number
        $nextCounterNumber = $lastCounter ? $lastCounter->token_number + 1 : 1;
        $is_duplicate = 0;

        if (Prescription::where('patient_id','=',$request->patient_id)
              ->whereDate('date',$today)
              ->where('hospital_id', request('hospital_id'))->exists()) {
                $is_duplicate = 1;
         }

        $obj = new Prescription;
        $obj->patient_id = $request->patient_id;
        $obj->counter_id = $request->counter_id;
        $obj->token_number = $nextCounterNumber ;
        $obj->hospital_id = $request->hospital_id;
        $obj->doctor_id = $request->doctor_id;
        $obj->is_duplicate = $is_duplicate;
        $obj->date = Carbon::today();
        $obj->status = 'paid';
        $obj->created_by = auth()->user()->id;
        $obj->save();

        session()->flash('success', 'Prescription generated successfully');
        return Redirect::route('prescriptions.index');

    }

    public function updateForm($request = false)
    {

        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'patient_id' => ['required'],
            'doctor_id' => ['required'],
            'hospital_id' => ['required'],
        ],[
            'patient_id.required' => 'Patient is required',
            'doctor_id.required' => 'Doctor is required',
            'hospital_id.required' => 'Hospital is required',
        ]);

        $obj = Prescription::find($request->id);
        $obj->hospital_id = $request->hospital_id;
        $obj->patient_id = $request->patient_id;
        $obj->doctor_id = $request->doctor_id;
        $obj->date = Carbon::today();
        $obj->status = 'paid';
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        session()->flash('success', 'Prescription updated successfully');
        return Redirect::route('prescriptions.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Prescription has been deleted successfully',
        ]);
    }

}
