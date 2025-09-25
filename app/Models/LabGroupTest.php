<?php

namespace App\Models;

use Response;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\LabGroup;
use App\Models\Department;
use App\Models\UserPreferences;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LabGroupTestResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabGroupTest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['lab_group_id', 'investigation_id', 'dated','report_date','generated_pdf_path','created_by','status'];

    public function group()
    {
        return $this->belongsTo(LabGroup::class, 'lab_group_id');
    }

    public function results()
    {
        return $this->hasMany(LabGroupTestResult::class, 'lab_group_test_id');
    }

    public static function getLabGroupTests ($lab_group_id) {


        $data = self::join('investigations as inv','inv.id','lab_group_tests.investigation_id')
                ->join('lab_groups as lg','lg.id','lab_group_tests.lab_group_id')
                ->select([
                    'inv.name as name',
                    'inv.description as description',
                    'lg.lab_group_number as lab_group_number',
                    'lab_group_tests.*'
                ])
                ->where('lab_group_id',$lab_group_id)
                ->paginate(10);

                return $data;
    }

    public static function getLabGroupTestStats ($lab_group_id) {

                $total_tests = self::join('investigations as inv','inv.id','lab_group_tests.investigation_id')
                ->join('lab_groups as lg','lg.id','lab_group_tests.lab_group_id')
                ->select([
                    'inv.name as name',
                    'inv.description as description',
                    'lg.lab_group_number as lab_group_number',
                    'lab_group_tests.*'
                ])
                ->where('lab_group_id',$lab_group_id)
                ->get();

              $stats['total'] = count($total_tests);

              $pending_tests = self::join('investigations as inv','inv.id','lab_group_tests.investigation_id')
                ->join('lab_groups as lg','lg.id','lab_group_tests.lab_group_id')
                ->select([
                    'inv.name as name',
                    'inv.description as description',
                    'lg.lab_group_number as lab_group_number',
                    'lab_group_tests.*'
                ])
                  ->where('lab_group_id',$lab_group_id)
                ->where('lab_group_tests.status','pending')
                ->get();

               $stats['pending'] = count($pending_tests);

              $collected_tests = self::join('investigations as inv','inv.id','lab_group_tests.investigation_id')
                ->join('lab_groups as lg','lg.id','lab_group_tests.lab_group_id')
                ->select([
                    'inv.name as name',
                    'inv.description as description',
                    'lg.lab_group_number as lab_group_number',
                    'lab_group_tests.*'
                ])
                  ->where('lab_group_id',$lab_group_id)
                ->where('lab_group_tests.status','collected')
                ->get();

                $stats['collected'] = count($collected_tests);

                return $stats;

    }

    public static function changeStatus($id, $status)
    {
        $adv = self::where('id', $id)->first();

         if (!$adv) {
        return "No record found";
           }

          if (!checkPersonPermission('change_lab_test_status_lab_group_detail_56')) {
        return ucfirst($adv->status);
          }
        if ($adv) {
            $adv->status = $status;
            $adv->update();
            return "status updated successfully";
        } else
            return "No record found";
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Lab test deleted successfully',
        ]);
    }

    public static function addMoreInvestigations ($lab_group_id, $request = false) {

        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'investigations.*' => ['required'],
        ]);

        $date = date('Y-m-d');
        foreach ($request->investigations as $investigation) {
            $matchThese = ['lab_group_id' => $lab_group_id, 'investigation_id' => $investigation];
            $labGroupTestResultObj = LabGroupTest::updateOrCreate($matchThese, [
                'dated' => $date,
                'report_date' => $date,
                'status' => 'pending',
                'created_by' => auth()->user()->id,
            ]);
        }

        session()->flash('success', 'Lab group test updated successfully');
        return redirect()->route('lab_groups.lab_tests',['id' => $lab_group_id]);

    }
}
