<?php

namespace App\Models;

use Response;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\LabInvoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\LabGroupTest;
use App\Models\LabInvoiceItem;
use App\Models\UserPreferences;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LabInvestigationPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['patient_id', 'clinical_diagnosis_id', 'lab_group_number', 'doctor_id', 'generated_pdf_path', 'status', 'receipt_name', 'receipt_file_path'];
    public function tests()
    {
        return $this->hasMany(LabGroupTest::class, 'lab_group_id');
    }

    public static function getLabGroupDetailsById($id)
    {
        return self::join('patients as patient', 'patient.id', 'lab_groups.patient_id')
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
            ->where('lab_groups.id', $id)
            ->first();

    }

    public function download_patient_receipt($id)
    {

        $lab_group_id = intVal($id);
        $lab_group_data = LabGroup::where('id', $lab_group_id)->first();
        $lab_group_tests = LabGroupTest::getLabGroupTests($lab_group_data->id);
        $lab_invoice_data = LabInvoice::where('id', $lab_group_data->lab_invoice_id)->first();
        $total_investigation_items = count($lab_group_tests);
        $fill_data_investigations = 0;
        $invoice_items = LabInvoiceItem::getInvoiceItems($lab_invoice_data->id);

        if ($total_investigation_items < 6) {
            $fill_data_investigations = 6 - $total_investigation_items;
        } else {
            $fill_data_investigations = 0;
        }

        $patient_data = Patient::withTrashed()->find($lab_group_data->patient_id);
        $doctor_data = Doctor::withTrashed()->find($lab_group_data->doctor_id);
        $department_data = Department::find($doctor_data->department_id);
        $hospital = Hospital::find($lab_group_data->hospital_id);
        // $customPaper = array(0, 0, 567.00, 283.80);

        $lab_group_number = $lab_group_data->lab_group_number;
        $encrypted_lab_group_number = encrypt($lab_group_number);

        $button_url = config('app.url') . '/pathology/check-qr-code/' . $encrypted_lab_group_number;
        $qrCode = \QrCode::size(60)->generate($button_url);

        if ($total_investigation_items > 6) {

            if ($total_investigation_items < 8) {
                $fill_data_investigations = 8 - $total_investigation_items;
            } else {
                $fill_data_investigations = 0;
            }

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.lab_receipts.lab_collection_report_portrait', compact(
                    'lab_group_data',
                    'patient_data',
                    'invoice_items',
                    'doctor_data',
                    'department_data',
                    'hospital',
                    'lab_group_tests',
                    'qrCode',
                    'lab_invoice_data',
                    'fill_data_investigations'
                ))
                ->setPaper('a4', 'portrait');
        } else {
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('documents.lab_receipts.lab_collection_report_landscape', compact(
                    'lab_group_data',
                    'patient_data',
                    'invoice_items',
                    'doctor_data',
                    'department_data',
                    'hospital',
                    'lab_group_tests',
                    'qrCode',
                    'lab_invoice_data',
                    'fill_data_investigations'
                ))
                ->setPaper('a4', 'landscape');
        }

        // ->setPaper('A6');

        $dir = ClinicalDiagnosis::getLabReceiptsDir();
        $extension = 'pdf';
        $FileName = strtolower(time() . '_' . rand(1000, 9999) . '.' . $extension);
        $path = public_path() . '/' . $dir;
        File::isDirectory(directory: $path) or File::makeDirectory($path, 0777, true, true);
        $pdf->save($path . $FileName);
        $file = $path . $FileName;
        $lab_group_data->receipt_name = $FileName;
        $lab_group_data->receipt_file_path = url($dir . $FileName);
        $lab_group_data->update();

        return $pdf->stream('investigations_slip_download.pdf');

    }


    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'patient_id' => ['required'],
            'doctor_id' => ['nullable'],
            'hospital_id' => ['required'],
            'investigations' => ['required', 'array'],
            'investigations.*' => ['exists:investigations,id'],
        ], [
            'patient_id.required' => 'Please select a patient',
            // 'doctor_id.required' => 'Please select a doctor',
            'hospital_id.required' => 'Please select a hospital',
            'investigations.required' => 'Please select at least one investigation',
        ]);

        $obj = new LabGroup;
        $obj->patient_id = $request->patient_id;
        $obj->doctor_id = $request->doctor_id;
        $obj->hospital_id = $request->hospital_id;
        $obj->lab_group_number = now()->format('YmdHis');
        $obj->created_by = auth()->user()->id;
        $obj->save();

        $investigations = $request->investigations;
        if ($investigations) {
            $date = date('Y-m-d');
            foreach ($investigations as $investigation) {
                $matchThese = ['lab_group_id' => $obj->id, 'investigation_id' => $investigation];
                LabGroupTest::updateOrCreate($matchThese, [
                    'dated' => $date,
                    'report_date' => $date,
                    'status' => 'pending',
                    'created_by' => auth()->user()->id,
                ]);
            }
        }

        $now = Carbon::now();
        $LabInvoiceObj = new LabInvoice;
        $LabInvoiceObj->patient_id = $request->patient_id;
        $LabInvoiceObj->date_issued = Carbon::parse($now);
        $LabInvoiceObj->total_amount = 0;
        $LabInvoiceObj->hospital_id = $request->hospital_id;
        $LabInvoiceObj->discount_amount = 0; // This is not used anymore, but kept for backward compatibility
        $LabInvoiceObj->discount_percentage = $request->discount_percentage;
        $LabInvoiceObj->net_amount = 0;
        $LabInvoiceObj->amount_received = 0;
        $LabInvoiceObj->created_by = auth()->user()->id;
        $LabInvoiceObj->lab_group_id = $obj->id;
        $LabInvoiceObj->save();

        $price = 0;
        $total_amount = 0;
        $total_investigation_items = 0;
        $fill_data_investigations = 0;
        $discount_amount = 0;
        $patient = null;

        if ($request->investigations) {
            $investigations = $request->investigations;
            foreach ($investigations as $investigation) {
                $patient = Patient::find($obj->patient_id);
                if ($patient->patient_category) {

                    $priceObj = LabInvestigationPrice::getInvestigationPrice($investigation);
                    $price = (integer) $priceObj->price;

                    LabInvoiceItem::Create([
                        'price' => $price,
                        'investigation_price_id' => $priceObj->id,
                        'lab_invoice_id' => $LabInvoiceObj->id,
                        'investigation_id' => $investigation,
                        'created_by' => auth()->user()->id
                    ]);

                    $total_amount = $total_amount + $price;
                    $total_investigation_items++;

                }
            }
        }

        $LabInvoiceObj->total_amount = $total_amount;
        $discount_amount = ($LabInvoiceObj->discount_percentage / 100) * $total_amount;
        $LabInvoiceObj->net_amount = $total_amount - $discount_amount;
        $LabInvoiceObj->amount_received = $LabInvoiceObj->net_amount;
        $LabInvoiceObj->discount_amount = $discount_amount;
        $LabInvoiceObj->receipt_number = intval($LabInvoiceObj->id) + 1000;
        $LabInvoiceObj->invoice_sequence = generateLabSequenceInvoice($LabInvoiceObj->receipt_number);
        $LabInvoiceObj->update();

        if ($total_investigation_items < 6) {
            $fill_data_investigations = 6 - $total_investigation_items;
        } else {
            $fill_data_investigations = 0;
        }

        $obj->lab_invoice_id = $LabInvoiceObj->id;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        // $this->download_patient_receipt($obj->id);

        session()->flash('success', 'Lab Group created successfully');
        return Redirect::route('lab_groups.index');
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }
        $obj = LabGroup::find($request->id);

        $request->validate([
            'patient_id' => ['required'],
            'doctor_id' => ['nullable'],
            'investigations' => ['required', 'array'],
            'investigations.*' => ['exists:investigations,id'],
            'hospital_id' => ['required'],
        ], [
            'patient_id.required' => 'Please select a patient',
            'investigations.required' => 'Please select at least one investigation',
            'investigations.array' => 'Invalid investigations data',
            'investigations.*.exists' => 'Selected investigation does not exist',
        ]);

        $obj->patient_id = $request->patient_id;
        $obj->doctor_id = $request->doctor_id;
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        $hospital = Hospital::find($obj->hospital_id);
        $now = Carbon::now();

        $investigations = $request->investigations;
        if ($investigations) {
            $date = date('Y-m-d');
            LabGroupTest::where('lab_group_id', $obj->id)->delete();
            foreach ($investigations as $investigation) {

                $labGroupTest = LabGroupTest::withTrashed()
                    ->where([
                        'lab_group_id' => $obj->id,
                        'investigation_id' => $investigation,
                    ])->first();

                if ($labGroupTest) {
                    $labGroupTest->restore();
                    $labGroupTest->update([
                        'dated' => $date,
                        'report_date' => $date,
                        'status' => 'pending',
                        'updated_by' => auth()->id(),
                    ]);
                } else {
                    LabGroupTest::create([
                        'lab_group_id' => $obj->id,
                        'investigation_id' => $investigation,
                        'dated' => $date,
                        'report_date' => $date,
                        'status' => 'pending',
                        'created_by' => auth()->id(),
                    ]);
                }
            }
        }

        $LabInvoiceObj = LabInvoice::find($obj->lab_invoice_id);
        $LabInvoiceObj->patient_id = $obj->patient_id;
        $LabInvoiceObj->total_amount = 0;
        $LabInvoiceObj->hospital_id = $request->hospital_id;
        $LabInvoiceObj->discount_amount = 0;
        $LabInvoiceObj->discount_percentage = $request->discount_percentage;
        $LabInvoiceObj->net_amount = 0;
        $LabInvoiceObj->amount_received = 0;
        $LabInvoiceObj->updated_by = auth()->user()->id;
        $LabInvoiceObj->lab_group_id = $obj->id;
        $LabInvoiceObj->update();

        $price = 0;
        $total_amount = 0;
        $total_investigation_items = 0;
        $discount_amount = 0;
        $patient = null;

        if ($request->investigations) {

            $investigations = $request->investigations;
            LabInvoiceItem::where('lab_invoice_id', $LabInvoiceObj->id)->delete();

            foreach ($investigations as $investigation) {
                $patient = Patient::find($obj->patient_id);

                if ($patient->patient_category) {

                    $priceObj = LabInvestigationPrice::getInvestigationPrice($investigation);
                    $price = (int) $priceObj->price;
                    $invoiceItem = LabInvoiceItem::withTrashed()
                        ->where('lab_invoice_id', $LabInvoiceObj->id)
                        ->where('investigation_id', $investigation)
                        ->first();

                    if ($invoiceItem) {
                        $invoiceItem->restore();
                        $invoiceItem->update([
                            'price' => $price,
                            'investigation_price_id' => $priceObj->id,
                            'updated_by' => auth()->id(),
                        ]);
                    } else {
                        LabInvoiceItem::create([
                            'lab_invoice_id' => $LabInvoiceObj->id,
                            'investigation_id' => $investigation,
                            'price' => $price,
                            'investigation_price_id' => $priceObj->id,
                            'created_by' => auth()->id(),
                        ]);
                    }

                    $total_amount += $price;
                    $total_investigation_items++;
                }
            }
        }


        $LabInvoiceObj->total_amount = $total_amount;
        $discount_amount = ($LabInvoiceObj->discount_percentage / 100) * $total_amount;
        $LabInvoiceObj->net_amount = $total_amount - $discount_amount;
        $LabInvoiceObj->amount_received = $LabInvoiceObj->net_amount;
        $LabInvoiceObj->discount_amount = $discount_amount;
        $LabInvoiceObj->update();

        session()->flash('success', 'Lab Record updated successfully');
        return Redirect::route('lab_groups.index');

    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['doctor_id'] = $request->has('doctor_id') ? $request->get('doctor_id') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::join('patients as patient', 'patient.id', 'lab_groups.patient_id')
            ->join('hospitals as h', 'h.id', 'lab_groups.hospital_id')
            ->join('doctors as d', 'd.id', 'lab_groups.doctor_id')
            ->leftjoin('clinical_diagnoses as cd', 'cd.id', 'lab_groups.clinical_diagnosis_id')
            ->select([
                'patient.name_of_patient as patient_name',
                'patient.cnic_number as cnic_number',
                'patient.patient_mr_number as patient_mr_number',
                'h.name as hospital_name',
                'd.doctor_name as doctor_name',
                'lab_groups.*'
            ]);

        if ($search['q']) {
            $data = $data->where('patient.patient_mr_number', 'iLIKE', "%{$search['q']}%")
                ->orWhere('lab_groups.lab_group_number', 'iLIKE', "%{$search['q']}%")
                ->orWhere('patient.cnic_number', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['doctor_id']) {
            $data = $data->where('lab_groups.doctor_id', $search['doctor_id']);
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 'pending') {
                $data = $data->where('lab_groups.status', 'pending');
            } elseif ($search['status'] == 'completed') {
                $data = $data->where('lab_groups.status', 'completed');
            } elseif ($search['status'] == 'cancelled') {
                $data = $data->where('lab_groups.status', 'cancelled');
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('lab_groups.created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }
    public static function changeStatus($id, $status)
    {
        $adv = self::where('id', $id)->first();
        if (!$adv) {
            return "No record found";
        }

        if (!checkPersonPermission('change_status_lab_groups_55')) {
            return ucfirst($adv->status);
        }
        if ($adv) {
            $adv->status = $status;
            $adv->update();
            return "status updated successfully";
        } else
            return "No record found";
    }

    public static function getLabGroupTestsDir()
    {
        return 'assets/lab_groups/tests/';
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Lab group deleted successfully',
        ]);
    }

}
