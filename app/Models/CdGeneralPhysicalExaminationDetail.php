<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Redirect;

class CdGeneralPhysicalExaminationDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cd_gpe_id', 'gpe_id', 'created_by', 'updated_by', 'deleted_by'];

    // Relationships
    public function cdGeneralPhysicalExamination()
    {
        return $this->belongsTo(CdGeneralPhysicalExamination::class, 'cd_gpe_id');
    }

    public function generalPhysicalExamination()
    {
        return $this->belongsTo(GeneralPhysicalExamination::class, 'gpe_id');
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
            $data = $data->where('cd_general_physical_examination_details.gpe_id', 'iLIKE', "%{$search['q']}%");
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->whereNotNull('cd_general_physical_examination_details.id')
            ->whereNull('cd_general_physical_examination_details.deleted_at')
            ->latest()
            ->paginate(10);

        return $rtn;
    }

    public function addForm()
    {
        request()->validate([
            'cd_gpe_id' => ['required', 'exists:cd_general_physical_examinations,id'],
            'gpe_id' => ['required', 'exists:general_physical_examinations,id']
        ]);

        $obj = CdGeneralPhysicalExaminationDetail::create([
            'cd_gpe_id' => request('cd_gpe_id'),
            'gpe_id' => request('gpe_id'),
            'created_by' => auth()->user()->id
        ]);

        session()->flash('success', 'General Physical Examination detail added successfully');
        return Redirect::route('cd_general_physical_examination_details.index');
    }

    public function updateForm($id)
    {
        request()->validate([
            'cd_gpe_id' => ['required', 'exists:cd_general_physical_examinations,id'],
            'gpe_id' => ['required', 'exists:general_physical_examinations,id']
        ]);

        $obj = CdGeneralPhysicalExaminationDetail::find($id);
        $obj->update([
            'cd_gpe_id' => request('cd_gpe_id'),
            'gpe_id' => request('gpe_id'),
            'updated_by' => auth()->user()->id
        ]);

        session()->flash('success', 'General Physical Examination detail updated successfully');
        return Redirect::route('cd_general_physical_examination_details.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'General Physical Examination detail deleted successfully',
        ]);
    }
}
