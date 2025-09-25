<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdTreatment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cd_id',
        'medicine_id',
        'treatment_dosage_id',
        'treatment_duration_id',
        'treatment_dose_interval_id',
        'treatment_frequency_id',
        'treatment_form_id',
        'treatment_route_id',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function cd()
    {
        return $this->belongsTo(ClinicalDiagnosis::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicines::class);
    }

    public function treatmentDosage()
    {
        return $this->belongsTo(TreatmentDosage::class);
    }

    public function treatmentDuration()
    {
        return $this->belongsTo(TreatmentDuration::class);
    }

    public function treatmentDoseInterval()
    {
        return $this->belongsTo(TreatmentDoseInterval::class);
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getTreatmentData($cd_id)
    {
        $data = self::leftjoin('medicines as m', 'm.id', 'cd_treatments.medicine_id')
            ->leftjoin('treatment_dosage as td', 'td.id', 'cd_treatments.treatment_dosage_id')
            ->leftjoin('treatment_duration as treatment_dur', 'treatment_dur.id', 'cd_treatments.treatment_duration_id')
            ->leftjoin('treatment_dose_interval as tdi', 'tdi.id', 'cd_treatments.treatment_dose_interval_id')
            ->leftjoin('medicine_routes as mr', 'mr.id', 'cd_treatments.treatment_route_id')
            ->leftjoin('dosage_forms as df', 'df.id', 'cd_treatments.treatment_form_id')
            ->select([
                'm.name as medicine_name',
                'td.name as treatment_dosage_name',
                'treatment_dur.name as treatment_duration',
                'cd_treatments.remarks as remarks',
                'tdi.name as treatment_dose_interval',
                'mr.name as route_name',
                'df.name as form_name',
            ])
            ->where('cd_treatments.cd_id', $cd_id)
            ->get();

        return $data;

    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('cd_id', $search['q']);
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm()
{
    $cd_id = request('cd_id');

    // If no treatment data is provided, delete existing records and return
    if (!request()->has('kt_docs_repeater_advanced_treatment')) {
        CdTreatment::where('cd_id', $cd_id)->delete();
        session()->flash('success', 'All medications removed successfully');
        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=disposal");
    }

    $repeater_data = request('kt_docs_repeater_advanced_treatment', []);

    // If empty array submitted, delete existing records and return
    if (empty($repeater_data)) {
        CdTreatment::where('cd_id', $cd_id)->delete();
        session()->flash('success', 'All medications removed successfully');
        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=disposal");
    }

    // Proceed with validation only if there's data to validate
    $validator = Validator::make(request()->all(),[
        'cd_id' => request('cd_id'),
        'kt_docs_repeater_advanced_treatment.*.selectMedicine' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectDosage' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectDuration' => 'required',
        // 'kt_docs_repeater_advanced_treatment.*.selectInterval' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectForm' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectRoute' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectFrequency' => 'required',
    ], [
        'kt_docs_repeater_advanced_treatment.*.selectMedicine.required' => 'Medicine is required',
        'kt_docs_repeater_advanced_treatment.*.selectDosage.required' => 'Dosage is required',
        'kt_docs_repeater_advanced_treatment.*.selectDuration.required' => 'Duration is required',
        // 'kt_docs_repeater_advanced_treatment.*.selectInterval.required' => 'Interval is required',
        'kt_docs_repeater_advanced_treatment.*.selectForm.required' => 'Form is required',
        'kt_docs_repeater_advanced_treatment.*.selectRoute.required' => 'Route is required',
        'kt_docs_repeater_advanced_treatment.*.selectFrequency.required' => 'Frequency is required',


    ]);

    if ($validator->fails()) {
        return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => 'treatment'])
            ->withErrors($validator)
            ->withInput();
    }

    try {
        \DB::beginTransaction();

        // Delete existing records first
        CdTreatment::where('cd_id', $cd_id)->delete();

        // Add new records
        foreach ($repeater_data as $key => $value) {
            if (empty($value['selectMedicine'])) {
                continue;
            }

            $medicineId = $value['selectMedicine'];

                // If the value is not numeric, treat it as a new custom tag
                if (!is_numeric($medicineId)) {
                    $newMedicine = Medicines::create([
                        'name' => $medicineId,
                        'status' => 1,
                        'verification_status' => 'pending',
                        'is_manual' => 1,
                        'created_by' => auth()->user()->id,
                    ]);

                    $medicineId = $newMedicine->id;
                }

            CdTreatment::create([
                'cd_id' => $cd_id,
                'medicine_id' => $medicineId,
                'treatment_dosage_id' => $value['selectDosage'],
                'treatment_duration_id' => $value['selectDuration'],
                'treatment_frequency_id' => $value['selectFrequency'],
                'treatment_dose_interval_id' => $value['selectFrequency'],
                'treatment_form_id' => $value['selectForm'],
                'treatment_route_id' => $value['selectRoute'],
                'remarks' => $value['remarks'] ?? null,
                'created_by' => auth()->user()->id
            ]);
        }

        \DB::commit();
        session()->flash('success', 'Medication added successfully');

    } catch (\Exception $e) {
        \DB::rollback();
        session()->flash('error', 'Error adding medication: ' . $e->getMessage());
        return back();
    }

    return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=disposal");
}

public function updateForm($request = false)
{
    $cd_id = request('cd_id');

    // If no treatment data is provided, delete existing records and return
    if (!request()->has('kt_docs_repeater_advanced_treatment')) {
        CdTreatment::where('cd_id', $cd_id)->delete();
        session()->flash('success', 'All medications removed successfully');
        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=disposal");
    }

    $repeater_data = request('kt_docs_repeater_advanced_treatment', []);

    // If empty array submitted, delete existing records and return
    if (empty($repeater_data)) {
        CdTreatment::where('cd_id', $cd_id)->delete();
        session()->flash('success', 'All medications removed successfully');
        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=disposal");
    }

    // Proceed with validation only if there's data to validate
    request()->validate([
        'cd_id' => request('cd_id'),
        'kt_docs_repeater_advanced_treatment.*.selectMedicine' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectDosage' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectDuration' => 'required',
        // 'kt_docs_repeater_advanced_treatment.*.selectInterval' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectForm' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectRoute' => 'required',
        'kt_docs_repeater_advanced_treatment.*.selectFrequency' => 'required',
    ], [
        'kt_docs_repeater_advanced_treatment.*.selectMedicine.required' => 'Medicine is required',
        'kt_docs_repeater_advanced_treatment.*.selectDosage.required' => 'Dosage is required',
        'kt_docs_repeater_advanced_treatment.*.selectDuration.required' => 'Duration is required',
        // 'kt_docs_repeater_advanced_treatment.*.selectInterval.required' => 'Interval is required',
        'kt_docs_repeater_advanced_treatment.*.selectForm.required' => 'Form is required',
        'kt_docs_repeater_advanced_treatment.*.selectRoute.required' => 'Route is required',
        'kt_docs_repeater_advanced_treatment.*.selectFrequency.required' => 'Frequency is required',
    ]);

    try {
        \DB::beginTransaction();

        // Delete all existing records first
        CdTreatment::where('cd_id', $cd_id)->delete();

        // Add new records
        foreach ($repeater_data as $key => $value) {
            if (empty($value['selectMedicine'])) {
                continue;
            }

            $medicineId = $value['selectMedicine'];
             if (!is_numeric($medicineId)) {
                        $newMedicine = Medicines::create([
                            'name' => $medicineId,
                            'status' => 1,
                            'verification_status' => 'pending',
                            'is_manual' => 1,
                            'created_by' => auth()->user()->id,
                        ]);

                        $medicineId = $newMedicine->id;
                    }

            CdTreatment::create([
                'cd_id' => $cd_id,
                'medicine_id' => $medicineId,
                'treatment_dosage_id' => $value['selectDosage'],
                'treatment_duration_id' => $value['selectDuration'],
                'treatment_frequency_id' => $value['selectFrequency'],
                'treatment_dose_interval_id' => $value['selectFrequency'],
                'treatment_form_id' => $value['selectForm'],
                'treatment_route_id' => $value['selectRoute'],
                'remarks' => $value['remarks'] ?? null,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
        }

        \DB::commit();
        session()->flash('success', 'Medications updated successfully');

    } catch (\Exception $e) {
        \DB::rollback();
        session()->flash('error', 'Error updating medication: ' . $e->getMessage());
        return back();
    }

    return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName=disposal");
}

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Cd Medication has been deleted successfully',
        ]);
    }

}
