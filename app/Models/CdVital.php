<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdVital extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cd_id', 'vital_id', 'value', 'created_by', 'updated_by', 'deleted_by'];

    // Relationships
    public function clinicalDiagnosis()
    {
        return $this->belongsTo(ClinicalDiagnosis::class, 'cd_id');
    }

    public function vital()
    {
        return $this->belongsTo(Vital::class, 'vital_id');
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
            $data = $data->where('cd_vitals.value', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('cd_vitals.id')
            ->whereNull('cd_vitals.deleted_at')
            ->latest()
            ->paginate(10);

        return $rtn;
    }

    public function addVitalForm () {
      $vitals = request('vitals');
        $cd_id = request('cd_id');
        $tabName = 'vitals';

        // Get vital names for custom messages
        // $vitalNames = Vital::whereIn('id', array_keys($vitals ?? []))
        //     ->pluck('name', 'id')
        //     ->toArray();

        // // Build custom messages
        // $messages = [];
        // foreach ($vitalNames as $id => $name) {
        //     $messages["vitals.{$id}.required"] = "The {$name} field is required";
        // }

        // // Validate with custom messages
        // request()->validate([
        //     'vitals.*' => ['required', 'string']
        // ], $messages);

        // Check if vitals data is empty or missing
        if (empty($vitals) || !is_array($vitals) || !$cd_id) {
            session()->flash('warning', 'No vitals were provided to add.');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }

        $added = false;
        foreach ($vitals as $key => $value) {
            $vital_id = (int) str_ireplace(array(
                '\'',
                '"',
                ',',
                ';',
                '<',
                '>'
            ), ' ', $key);


            if ($vital_id > 0 && !empty($value)) {
                CdVital::create([
                    'cd_id' => $cd_id,
                    'vital_id' => $vital_id,
                    'value' => $value,
                    'created_by' => auth()->user()->id
                ]);
                $added = true;
            }
        }

        if ($added) {
            session()->flash('success', 'Vital details added successfully.');
        } else {
            session()->flash('warning', 'No valid vitals were provided for addition.');
        }

        return redirect(route('clinical_diagnosis.vitals_form', ['id' => $cd_id]) . "?tabName={$tabName}");
    }

    public function updateVitalForm () {
      $vitals = request('vitals');
        $cd_id = request('cd_id');
        $tabName = 'vitals';

        // Get vital names for custom messages
        // $vitalNames = Vital::whereIn('id', array_keys($vitals ?? []))
        //     ->pluck('name', 'id')
        //     ->toArray();

        // Build custom messages
        // $messages = [];
        // foreach ($vitalNames as $id => $name) {
        //     $messages["vitals.{$id}.required"] = "The {$name} field is required";
        // }

        // // Validate with custom messages
        // request()->validate([
        //     'vitals.*' => ['required', 'string']
        // ], $messages);
        // Check if vitals data is empty or missing
        if (empty($vitals) || !is_array($vitals) || !$cd_id) {
            session()->flash('warning', 'No vitals were provided.');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }
        $updated = false;

        foreach ($vitals as $key => $value) {
            $vital_id = (int) str_ireplace(array(
                '\'',
                '"',
                ',',
                ';',
                '<',
                '>'
            ), ' ', $key);

            $matchThese = ['cd_id' => $cd_id, 'vital_id' => $vital_id];
            if ($vital_id > 0) {
                if ($value === null || $value === '') {
                    // If value is empty, delete the existing record (if it exists)
                    CdVital::where($matchThese)->delete();
                    $updated = true;
                } else {
                    // If value is provided, update or create the record
                    CdVital::updateOrCreate(
                        $matchThese,
                        [
                            'value' => $value,
                            'updated_by' => auth()->user()->id
                        ]
                    );
                    $updated = true;
                }
            }
        }

        if ($updated) {
            session()->flash('success', 'Vital details updated successfully.');
        } else {
            session()->flash('warning', 'No vitals were provided.');
        }
        return redirect(route('clinical_diagnosis.vitals_form', ['id' => $cd_id]) . "?tabName={$tabName}");
    }

    public function addForm()
    {
        $vitals = request('vitals');
        $cd_id = request('cd_id');
        $tabName = 'brief_history';

        // Get vital names for custom messages
        // $vitalNames = Vital::whereIn('id', array_keys($vitals ?? []))
        //     ->pluck('name', 'id')
        //     ->toArray();

        // // Build custom messages
        // $messages = [];
        // foreach ($vitalNames as $id => $name) {
        //     $messages["vitals.{$id}.required"] = "The {$name} field is required";
        // }

        // // Validate with custom messages
        // request()->validate([
        //     'vitals.*' => ['required', 'string']
        // ], $messages);

        // Check if vitals data is empty or missing
        if (empty($vitals) || !is_array($vitals) || !$cd_id) {
            session()->flash('warning', 'No vitals were provided to add.');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }

        $added = false;
        foreach ($vitals as $key => $value) {
            $vital_id = (int) str_ireplace(array(
                '\'',
                '"',
                ',',
                ';',
                '<',
                '>'
            ), ' ', $key);


            if ($vital_id > 0 && !empty($value)) {
                CdVital::create([
                    'cd_id' => $cd_id,
                    'vital_id' => $vital_id,
                    'value' => $value,
                    'created_by' => auth()->user()->id
                ]);
                $added = true;
            }
        }

        if ($added) {
            session()->flash('success', 'Vital details added successfully.');
        } else {
            session()->flash('warning', 'No valid vitals were provided for addition.');
        }

        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
    }

    public function updateForm()
    {
        $vitals = request('vitals');
        $cd_id = request('cd_id');
        $tabName = 'brief_history';

        // Get vital names for custom messages
        // $vitalNames = Vital::whereIn('id', array_keys($vitals ?? []))
        //     ->pluck('name', 'id')
        //     ->toArray();

        // Build custom messages
        // $messages = [];
        // foreach ($vitalNames as $id => $name) {
        //     $messages["vitals.{$id}.required"] = "The {$name} field is required";
        // }

        // // Validate with custom messages
        // request()->validate([
        //     'vitals.*' => ['required', 'string']
        // ], $messages);
        // Check if vitals data is empty or missing
        if (empty($vitals) || !is_array($vitals) || !$cd_id) {
            session()->flash('warning', 'No vitals were provided.');
            return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
        }
        $updated = false;

        foreach ($vitals as $key => $value) {
            $vital_id = (int) str_ireplace(array(
                '\'',
                '"',
                ',',
                ';',
                '<',
                '>'
            ), ' ', $key);

            $matchThese = ['cd_id' => $cd_id, 'vital_id' => $vital_id];
            if ($vital_id > 0) {
                if ($value === null || $value === '') {
                    // If value is empty, delete the existing record (if it exists)
                    CdVital::where($matchThese)->delete();
                    $updated = true;
                } else {
                    // If value is provided, update or create the record
                    CdVital::updateOrCreate(
                        $matchThese,
                        [
                            'value' => $value,
                            'updated_by' => auth()->user()->id
                        ]
                    );
                    $updated = true;
                }
            }
        }

        if ($updated) {
            session()->flash('success', 'Vital details updated successfully.');
        } else {
            session()->flash('warning', 'No vitals were provided.');
        }
        return redirect(route('clinical_diagnosis.detail_form', ['id' => $cd_id]) . "?tabName={$tabName}");
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Vital detail deleted successfully',
        ]);
    }
}
