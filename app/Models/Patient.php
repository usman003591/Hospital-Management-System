<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Validation\Rule;
use App\Models\AppointmentRequest;
use App\Jobs\SendVisitingCardEmail;
use Illuminate\Support\Facades\Log;
use App\Models\PatientEmergencyContact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'patients';

    protected $fillable = [
        'name_of_patient',
        'cnic_number',
        'date_of_birth',
        'gender',
        'patient_category',
        'permanent_address',
        'phone',
        'cell',
        'email',
        'age',
        'blood_group',
        'reffering_doctor_name',
        'contact_number',
        'address',
        'patient_mr_number',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getPatientsCount()
    {
        return self::count();
    }
    // public function getAgeAttribute(): ?int
    // {
    // return $this->year_of_birth
    //     ? now()->year - $this->year_of_birth
    //     : null;
    // }

    public function emergencyContact()
    {
        return $this->hasOne(PatientEmergencyContact::class);
    }

    public function externalDocuments()
    {
        return $this->hasMany(PatientExternalDocument::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function appointmentRequests()
    {
        return $this->hasMany(AppointmentRequest::class, 'patient_id');
    }
    // public function prescriptions()
    // {
    //     return $this->hasMany(Prescription::class, 'patient_id');
    // }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getForSelect()
    {
        return self::where('status', 1)->orderby('created_at', 'desc')->get();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select(['patients.*']);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('patients.name_of_patient', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('patients.patient_mr_number', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('patients.cnic_number', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('patients.cell', 'iLIKE', "%{$search['q']}%");
                });
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('patients.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('patients.status', 0);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('patients.created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {

    if ($request === false) {
        $request = request();
    }

    $existingPatient = null;
    if ($request->cnic_number) {
        $submittedCnic = preg_replace('/[^0-9]/', '', $request->cnic_number);

        if ($submittedCnic) {
            $existingPatient = Patient::whereRaw("REPLACE(cnic_number, '-', '') = ?", [$submittedCnic])->first();
        }
    }

    if ($existingPatient) {
            $patient_id = $existingPatient->id;

            if ($request->has('save_and_go_to_opd')) {
                session()->flash('success', 'Existing patient found. Redirecting to OPD...');
                return redirect()->to("/clinical_diagnosis/create?patient_id={$patient_id}");
            }

            if ($request->has('save_and_go_to_prescriptions')) {
                session()->flash('success', 'Existing patient found. Redirecting to Prescriptions...');
                return redirect()->to("/prescriptions/create?patient_id={$patient_id}");
            }

            session()->flash('info', 'Patient with this CNIC already exists.');
            return redirect()->back()->withInput();
        }

        $validator = Validator::make($request->all(), [
            'name_of_patient' => ['required'],
            'has_cnic' => 'sometimes',
            'cnic_number' => [ new RequiredIf($request->has_cnic == 0)  ],
            // 'date_of_birth' => ['required', 'before_or_equal:today'],
            'gender' => ['required'],
            'age' => ['required', 'numeric', 'min:0'],
            'patient_category' => ['required'],
            'permanent_address' => ['nullable'],
            'date_of_birth' => ['nullable', 'before_or_equal:today'],
            'phone' => ['nullable'],
            'cell' => ['required', 'digits_between:10,11'],
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique(Patient::class, 'email')->whereNull('deleted_at')
            ],
            'blood_group' => ['nullable', 'regex:/^(A|B|AB|O)[+-]$/'],
            'reffering_doctor_name' => ['nullable'],
            'contact_number' => ['nullable'],
            'address' => ['nullable'],
            'designation' => ['nullable', 'string', 'max:150'],
            'emergency_contact_name' => ['nullable', 'required_with:emergency_contact_relation,emergency_contact_number'],
            'emergency_contact_relation' => ['nullable', 'required_with:emergency_contact_name,emergency_contact_number'],
            'emergency_contact_number' => ['nullable', 'required_with:emergency_contact_name,emergency_contact_relation', 'digits_between:10,11'],
        ], [
            'name_of_patient.required' => 'The name of patient is required',
            'age.required' => 'Age is required',
            'age.min' => 'Invalid age',
            'gender.required' => 'The gender is required',
            'patient_category.required' => 'The patient category is required',
            'cell.digits_between' => 'The cell number must be of 10 or 11 digits',
            'blood_group.regex' => 'Please enter a valid blood group',
            'cnic_number.size' => 'The CNIC number field must be of 13 digits',
            'cnic_number.unique' => 'This CNIC number is already registered in the system',
            'email.unique' => 'This email is already registered in the system',
            'email.email' => 'Please enter a valid email',
            'email.max' => 'The email must not be greater than 100 characters',
            'emergency_contact_name.required_with' => 'The emergency contact name is required when other emergency contact details are provided.',
            'emergency_contact_relation.required_with' => 'The emergency contact relation is required when other emergency contact details are provided.',
            'emergency_contact_number.required_with' => 'The emergency contact number is required when other emergency contact details are provided.',
            'emergency_contact_number.digits_between' => 'The emergency contact number must be of 10 or 11 digits',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // $dobInput = $request->input('date_of_birth');
        // $dob = Carbon::createFromFormat('d/m/Y', $dobInput)->format('Y-m-d'); //converting the date format
        // $age = Carbon::now()->diff(Carbon::parse($dobInput))->y;

        try {

            $cnic = null;
            $has_cnic = true;
            if ($request->has_cnic) {
                $has_cnic = false;
                $cnic = generateIncrementedCnic();
            } else {
                $has_cnic = true;
                $cnic = $request->cnic_number;
            }
            // dd($cnic);

            $obj = new Patient;
            $obj->name_of_patient = $request->name_of_patient;
            $obj->cnic_number = $cnic;
            // $obj->date_of_birth = Carbon::parse($dobInput);
            $obj->gender = $request->gender;
            $obj->patient_category = $request->patient_category;
            $obj->permanent_address = $request->permanent_address;
            $obj->phone = $request->phone;
            $obj->cell = $request->cell;
            $obj->email = $request->email;
            $obj->age = $request->age;
            $obj->year_of_birth = Carbon::now()->year - $request->age;
            $obj->has_cnic = $has_cnic;
            $obj->date_of_birth = $request->date_of_birth;
            $obj->blood_group = $request->blood_group;
            $obj->reffering_doctor_name = $request->reffering_doctor_name;
            $obj->contact_number = $request->contact_number;
            $obj->address = $request->address;
            $obj->designation = $request->designation;
            $obj->created_by = auth()->user()->id;
            $obj->save();
            $obj->patient_mr_number = generate_mr_number($obj->patient_category, $obj->created_at->format('Y'), $obj->id);
            $obj->update();

            $obj->emergencyContact()->create([
                'name' => $request->emergency_contact_name,
                'relation' => $request->emergency_contact_relation,
                'contact' => $request->emergency_contact_number,
                'created_by' => auth()->user()->id,
            ]);

            $visitingCardPath = public_path('/documents/visiting_card.pdf');
            $obj->generateVistingCard($obj->id); // This should save the PDF to the correct location

            // if ($request->has('email')) {

            //     Log::info('Generated visiting card', [
            //         'patient_id' => $obj->id,
            //         'file_path' => $visitingCardPath
            //     ]);
            //     // Dispatch email job
            //     dispatch(new SendVisitingCardEmail($obj, $visitingCardPath))
            //     ->onQueue('sync');

            // }
            $patient_id = $obj->id;

            if ($request->has('save_and_go_to_opd')) {
                session()->flash('success', 'Patient created successfully. Redirecting to OPD...');
                return redirect()->to("/clinical_diagnosis/create?patient_id={$patient_id}");
            }

            if ($request->has('save_and_go_to_prescriptions')) {
                session()->flash('success', 'Patient created successfully. Redirecting to Prescriptions...');
                return redirect()->to("/prescriptions/create?patient_id={$patient_id}");
            }

            session()->flash('success', 'Patient created successfully');
            return Redirect::route('patients.index');

        } catch (\Exception $e) {
            Log::error('Error in patient creation process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);


            session()->flash('error', 'Error creating patient: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $obj = Patient::find($request->id);

        $validator = Validator::make($request->all(), [
             'name_of_patient' => ['required', 'regex:/^[A-Za-z\s.]+$/'],
            'cnic_number' => [
                'required',
                'size:15',
                Rule::unique(Patient::class, 'cnic_number')->ignore($obj->id)->whereNull('deleted_at')
            ],
            // 'date_of_birth' => ['required', 'before_or_equal:today'],
            'gender' => ['required'],
            'age' => ['required', 'numeric', 'min:0'],
            'patient_category' => ['required'],
            'permanent_address' => ['nullable'],
            'date_of_birth' => ['nullable', 'before_or_equal:today'],
            'phone' => ['nullable'],
            'cell' => ['nullable', 'digits_between:10,11'],
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique(Patient::class, 'email')->ignore($obj->id)->whereNull('deleted_at')
            ],
            'blood_group' => ['nullable', 'regex:/^(A|B|AB|O)[+-]$/'],
            'reffering_doctor_name' => ['nullable'],
            'contact_number' => ['nullable'],
            'address' => ['nullable'],
            'designation' => ['nullable', 'string', 'max:150'],
            'emergency_contact_name' => ['nullable', 'required_with:emergency_contact_relation,emergency_contact_number'],
            'emergency_contact_relation' => ['nullable', 'required_with:emergency_contact_name,emergency_contact_number'],
            'emergency_contact_number' => ['nullable', 'required_with:emergency_contact_name,emergency_contact_relation', 'digits_between:10,11'],
        ],[
            'name_of_patient.required' => 'The name of patient is required',
            'age.required' => 'Age is required',
            'age.min' => 'Invalid age',
            'gender.required' => 'The gender is required',
            'patient_category.required' => 'The patient category is required',
            'cell.digits_between' => 'The cell number must be of 10 or 11 digits',
            'blood_group.regex' => 'Please enter a valid blood group',
            'cnic_number.unique' => 'This CNIC number is already registered in the system',
            'email.unique' => 'This email is already registered in the system',
            'email.email' => 'Please enter a valid email',
            'email.max' => 'The email must not be greater than 100 characters',
            'emergency_contact_name.required_with' => 'The emergency contact name is required when other emergency contact details are provided.',
            'emergency_contact_relation.required_with' => 'The emergency contact relation is required when other emergency contact details are provided.',
            'emergency_contact_number.required_with' => 'The emergency contact number is required when other emergency contact details are provided.',
            'emergency_contact_number.digits_between' => 'The emergency contact number must be of 10 or 11 digits',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // $dobInput = $request->input('date_of_birth');
        // $dob = Carbon::createFromFormat('d/m/Y', $dobInput)->format('Y-m-d'); //converting the date format
        // $age = Carbon::now()->diff(Carbon::parse($dobInput))->y;

        $obj->name_of_patient = $request->name_of_patient;
        $obj->cnic_number = $request->cnic_number;
        // $obj->date_of_birth = Carbon::parse($dobInput);
        $obj->gender = $request->gender;
        $obj->patient_category = $request->patient_category;
        $obj->permanent_address = $request->permanent_address;
        $obj->phone = $request->phone;
        $obj->cell = $request->cell;
        $obj->email = $request->email;
        // $obj->age = $request->age;
        $obj->age = $request->age;
        $obj->year_of_birth = Carbon::now()->year - $request->age;
        $obj->date_of_birth = $request->date_of_birth;
        $obj->blood_group = $request->blood_group;
        $obj->reffering_doctor_name = $request->reffering_doctor_name;
        $obj->contact_number = $request->contact_number;
        $obj->designation = $request->designation;
        $obj->address = $request->address;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        $obj->patient_mr_number = generate_mr_number($obj->patient_category, $obj->created_at->format('Y'), $obj->id);
        $obj->update();

        $obj->emergencyContact()->updateOrCreate(
            ['patient_id' => $obj->id],
            [
                'name' => $request->emergency_contact_name,
                'relation' => $request->emergency_contact_relation,
                'contact' => $request->emergency_contact_number,
                'updated_by' => auth()->user()->id,
            ]
        );

        session()->flash('success', 'Patient updated successfully');
        return Redirect::route('patients.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Patient has been deleted successfully',
        ]);
    }

    public function generateVistingCard($id)
    {

        $patient_data = Patient::find($id);

        if ($patient_data) {

            $template = public_path() . "/documents/visiting_card.pdf";

            $output_prescription = public_path('/documents/visiting_card.pdf');
            $exsisting_prescription = public_path() . "/documents/output_visiting_card.pdf";

            $pdf = new \setasign\Fpdi\Fpdi();

            $pageCount = $pdf->setSourceFile($exsisting_prescription);
            $pageNo = 1;

            // for ($pageNo = 0; $pageNo <= $pageCount; $pageNo++) {

            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
            $pdf->SetFont('Helvetica', 'B', 10);
            $patient_category = str_replace("_", " ", $patient_data->patient_category);

            //Setting up department name and doctor name

            $pdf->SetXY(115, 85);
            $pdf->Cell(0, 10, $patient_data->name_of_patient);

            // $pdf->SetXY(75,70);
            // $pdf->Cell(0, 10, $patient_data->age);

            // $pdf->SetXY(130,70);
            // $pdf->Cell(0, 10, ucfirst($patient_data->gender));

            $pdf->SetXY(115, 92);
            $pdf->Cell(0, 10, $patient_data->cnic_number);

            $pdf->SetXY(115, 101);
            $pdf->Cell(0, 10, getBasicDateFormat($patient_data->date_of_birth, 'd-m-Y'));

            $pdf->SetXY(175, 101);
            $pdf->Cell(0, 10, $patient_data->blood_group);

            $pdf->SetXY(115, 109);
            $pdf->Cell(0, 10, $patient_data->address);

            $pdf->SetXY(115, 117);
            $pdf->Cell(0, 10, ucfirst($patient_data->cell));

            $patient_category = str_replace("_", " ", $patient_data->patient_category);

            $pdf->SetXY(164, 117);
            $pdf->Cell(0, 10, ucfirst($patient_category));

            $pdf->SetXY(115, 125);
            $pdf->Cell(0, 10, $patient_data->patient_mr_number);

            // }

            $pdf->Output($output_prescription, 'F'); // Save to file

            return response()->file($output_prescription, [
                'Content-Type' => 'application/pdf',
            ]);

        }

    }
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($patient) {
    //         $patient->prescriptions()->delete();
    //     });
    // }



}
