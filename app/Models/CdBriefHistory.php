<?php

namespace App\Models;


use App\Models\PatientsBriefHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdBriefHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cd_id', 'value', 'created_by', 'updated_by', 'deleted_by'];

    // Relationships
    public function clinicalDiagnosis()
    {
        return $this->belongsTo(ClinicalDiagnosis::class, 'cd_id');
    }

    // Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('cd_brief_histories.value', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('cd_brief_histories.id')
            ->whereNull('cd_brief_histories.deleted_at')
            ->latest()
            ->paginate(10);

        return $rtn;
    }

    public function addForm()
    {
        $cd_id = request('cd_id');
        $tabName = 'brief_history';
        $validator = Validator::make(request()->all(), [
            'value' => ['required', 'string']
        ], [
            'value.required' => 'Brief History is required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                ->withErrors($validator)
                ->withInput();
        }

        $obj = CdBriefHistory::create([
            'cd_id' => $cd_id,
            'value' => request('value'),
            'created_by' => auth()->user()->id
        ]);

        PatientsBriefHistory::updateOrCreate([
            'patient_id' => $obj->clinicalDiagnosis->patient_id,
            'description' => request('value'),
            'created_by' => auth()->id(),
            'clinical_diagnosis_id' => $cd_id,
        ]);

        session()->flash('success', 'Brief history added successfully');
        return redirect(route('clinical_diagnosis.detail_form',['id' => $cd_id]) . "?tabName=gpe");
    }

    public function updateForm()
    {
        $cd_id = request('cd_id');
        $tabName = 'brief_history';
        $validator = Validator::make(request()->all(),[
            'value' => ['required', 'string']
        ], [
            'value.required' => 'Brief History is required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('clinical_diagnosis.detail_form', ['id' => $cd_id, 'tabName' => $tabName])
                ->withErrors($validator)
                ->withInput();
        }

        $obj = CdBriefHistory::where('cd_id', $cd_id)->first();
        if ($obj) {
            $obj->update([
                'value' => request('value'),
                'updated_by' => auth()->id()
            ]);

            PatientsBriefHistory::updateOrCreate(
                [
                    'patient_id' => $obj->clinicalDiagnosis->patient_id,
                    'clinical_diagnosis_id' => $cd_id,
                ],
                [
                    'description' => request('value'),
                    'updated_by' => auth()->id(),
                ]
            );

            session()->flash('success', 'Brief history updated successfully');
        } else {
            session()->flash('error', 'Brief history record not found');
        }

        return redirect(route('clinical_diagnosis.detail_form',['id' => $cd_id]) . "?tabName=gpe");
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Brief history deleted successfully',
        ]);
    }
}
