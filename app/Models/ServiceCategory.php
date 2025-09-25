<?php

namespace App\Models;

use App\Models\Hospital;
use App\Models\UserPreferences;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service_categories';

    protected $fillable = [
        'service_name',
        'default_amount',
        'employee_amount',
        'resident_amount',
         'hospital_id',
        'category_code',
        'parent_code',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function getById($id): ?self
    {
        return self::where('id', $id)->first();
    }
    public function hospital()
       {
    return $this->belongsTo(Hospital::class);
      }


    public static function getAmountCharged($type, $service_category_id)
    {
        switch ($type) {
            case 'resident':
                $rtnVal = \DB::table('service_categories')->where('id', $service_category_id)->pluck('resident_amount');
                return $rtnVal;
                break;
            case 'non_resident':
                $rtnVal = \DB::table('service_categories')->where('id', $service_category_id)->pluck('default_amount');
                return $rtnVal;
                break;
            case 'employee':
                $rtnVal = \DB::table('service_categories')->where('id', $service_category_id)->pluck('employee_amount');
                return $rtnVal;
                break;
            default:
                $rtnVal = \DB::table('service_categories')->where('id', $service_category_id)->pluck('default_amount');
                return $rtnVal;
        }
    }

    public static function getActiveServiceCategories()
    {
        $parents = self::where('status', 1)->where('parent_id', 0)->get();
        foreach ($parents as $p) {
            $children = self::where('status', 1)->where('parent_id', $p->id)->get();
            $p->children = $children;
        }

        return $parents;
    }


    public static function getActiveHospitalServiceCategories()
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $parents = self::where('status', 1)->where('hospital_id',$hospital_id)->where('parent_id', 0)->get();
        foreach ($parents as $p) {
            $children = self::where('status', 1)->where('parent_id', $p->id)->get();
            $p->children = $children;
        }

        return $parents;
    }

    public static function getParentServiceCategories()
    {
        return self::where('parent_id', 0)->get();
    }

    public static function getForSelect()
    {
        return self::active()->get();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;
        $search['parent_id'] = $request->has('parent_id') ? $request->get('parent_id') : false;

        $data = \DB::table('service_categories as sc')
            ->leftjoin('service_categories as serviceCat', 'sc.parent_id', '=', 'serviceCat.id')
             ->leftJoin('hospitals as h', 'h.id', '=', 'sc.hospital_id')
            ->select([
                'sc.*',
                'serviceCat.service_name as parent_name',
                'serviceCat.id as parent_id',
                'h.name as hospital_name'
            ]);

        if ($search['q']) {
            $data->where('sc.service_name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('sc.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('sc.status', 0);
            }
        }

        if ($search['parent_id'] !== false) {
            if ($search['parent_id'] === '0') {
                $data->where('sc.parent_id', 0);
            } else {
                $data->where('sc.parent_id', $search['parent_id']);
            }
        }

        return [
            'search' => $search,
            'data' => $data->whereNotNull('sc.id')
                ->whereNull('sc.deleted_at')
                ->latest()->paginate(10)
        ];
    }

    public function addForm()
    {
        // dd(request()->all());
        request()->validate([
            'service_name' => [
                'required',
                // function ($attribute, $value, $fail) {

                //     $exists = DB::table('service_categories')
                //         ->whereRaw('LOWER(service_name) = ?', [strtolower($value)])
                //         ->whereNull('deleted_at')
                //         ->exists();

                //     if ($exists) {
                //         $fail('The service name has already been taken.');
                //     }
                // },
            ],
            'default_amount' => ['required', 'numeric', 'max_digits:12'],
            'employee_amount' => ['required', 'numeric', 'max_digits:12'],
            'resident_amount' => ['required', 'numeric', 'max_digits:12'],
            'hospital_id' => ['required', 'exists:hospitals,id'],
        ], [
            'service_name.required' => 'Service name is required',
            'default_amount.required' => 'Default amount is required',
            'employee_amount.required' => 'Employee amount is required',
            'resident_amount.required' => 'Resident amount is required',
            'default_amount.numeric' => 'Default amount must be a numeric value',
            'employee_amount.numeric' => 'Employee amount must be a numeric value',
            'resident_amount.numeric' => 'Resident amount must be a numeric value',
            'hospital_id.required' => 'Hospital is required',
        ]);

        $serviceCategory = ServiceCategory::create([
            'service_name' => request('service_name'),
            'default_amount' => request('default_amount'),
            'employee_amount' => request('employee_amount'),
            'resident_amount' => request('resident_amount'),
            'hospital_id' => request('hospital_id'),
            'created_by' => auth()->user()->id
        ]);

        if (request('parent_id') !== 0 && request('parent_id') !== null) {

            $serviceCategory->parent_id = request('parent_id');
            $serviceCategory->update();

            $service_name = $serviceCategory->service_name;
            $words = explode(" ", trim($service_name)); // Trim to remove extra spaces

            if (count($words) >= 2) {
                $firstLetters = strtoupper($words[0][0] . $words[1][0]); // First letters of first two words
            } else {
                $firstLetters = strtoupper($words[0][0] . $words[0][1]); // Only the first two letter of the first word
            }

            $generated_code = $firstLetters;
            $serviceCategory->parent_code = $generated_code;
            $serviceCategory->update();

        } else {

            $service_name = $serviceCategory->service_name;
            $words = explode(" ", trim($service_name)); // Trim to remove extra spaces

            if (count($words) >= 2) {
                $firstLetters = strtoupper($words[0][0] . $words[1][0]); // First letters of first two words
            } else {
                $firstLetters = strtoupper($words[0][0]); // Only the first letter of the first word
            }

            $generated_code = $firstLetters . $serviceCategory->id + 1000;
            $serviceCategory->category_code = $generated_code;
            $serviceCategory->update();

        }

        session()->flash('success', 'Service category created successfully');
        return Redirect::route('service_categories.index');
    }

    public function updateForm($id)
    {
        // $request = $request ?? request();
        $request = request();
        $request->validate([
            'service_name' => [
                'required',
                // function ($attribute, $value, $fail) use ($request) {

                //     $exists = DB::table('service_categories')
                //         ->whereRaw('LOWER(service_name) = ?', [strtolower($value)])
                //         ->where('id', '!=', $this->id)
                //         ->whereNull('deleted_at')
                //         ->exists();

                //     if ($exists) {
                //         $fail('The service name has already been taken.');
                //     }
                // },
            ],
            'default_amount' => ['required', 'numeric', 'max_digits:12'],
            'employee_amount' => ['required', 'numeric', 'max_digits:12'],
            'resident_amount' => ['required', 'numeric', 'max_digits:12'],
            'status' => ['required'],
        ], [
            'service_name.required' => 'Service name is required',
            'default_amount.required' => 'Default amount is required',
            'employee_amount.required' => 'Employee amount is required',
            'resident_amount.required' => 'Resident amount is required',
            'default_amount.numeric' => 'Default amount must be a numeric value',
            'employee_amount.numeric' => 'Employee amount must be a numeric value',
            'resident_amount.numeric' => 'Resident amount must be a numeric value',
            'status.required' => 'Status is required'
        ]);

        $obj = ServiceCategory::findOrFail($id);

        $obj->update([
            'service_name' => request('service_name'),
            'default_amount' => request('default_amount'),
            'employee_amount' => request('employee_amount'),
            'resident_amount' => request('resident_amount'),
            'status' => request('status'),
            'updated_by' => auth()->user()->id
        ]);

        if (request('parent_id') !== 0 && request('parent_id') !== null) {
            $obj->parent_id = request('parent_id');
            $obj->update();
        }

        session()->flash('success', 'Service category updated successfully');
        return Redirect::route('service_categories.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Service category has been deleted successfully',
        ]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
