<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'hospitals';

    protected $fillable = [
        'name',
        'description',
        'address',
        'logo',
        'project_logo',
        'hospital_cell',
        'hospital_phone',
        'hospital_abbreviation',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'hospital_id');
    }

    public static function getActiveHospitals()
    {
        return self::where('status', 1)->get();
    }

    //Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getForSelect()
    {
        return self::where('status', 1)->get();
    }

    public static function LogoPath()
    {
        return 'src/media/hospitals/logos/';
    }

    public static function ProjectLogoPath()
    {
        return 'src/media/hospitals/project_logos/';
    }

    public function UpdateLogo($save = true)
    {
        $request = request();
        $dir = self::LogoPath();
        $path = public_path() . '/' . $dir;
        $logo_path = public_path() . '/' . $this->logo;

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        if ($this->logo != '' && File::exists($logo_path)) {
            File::delete($logo_path);
        }

        if ($request->logo_remove == 1 && File::exists($logo_path)) {
            File::delete($logo_path);
            $this->logo = '';
        } else {
            $extension = $request->file('logo')->getClientOriginalExtension();
            $ImageName = strtolower($dir . Str::random(8) . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension);
            $request->file('logo')->move(self::LogoPath(), $ImageName);
            $this->logo = $ImageName;
        }

        if ($save) {
            $this->save();
        }
    }

    public function UpdateProjectLogo($save = true)
    {
        $request = request();
        $dir = self::ProjectLogoPath();
        $path = public_path() . '/' . $dir;
        $project_logo_path = public_path() . '/' . $this->project_logo;

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        if ($this->project_logo != '' && File::exists($project_logo_path)) {
            File::delete($project_logo_path);
        }

        if ($request->project_logo_remove == 1 && File::exists($project_logo_path)) {
            File::delete($project_logo_path);
            $this->project_logo = '';
        } else {
            $extension = $request->file('project_logo')->getClientOriginalExtension();
            $ImageName = strtolower($dir . Str::random(8) . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension);
            $request->file('project_logo')->move(self::ProjectLogoPath(), $ImageName);
            $this->project_logo = $ImageName;
        }

        if ($save) {
            $this->save();
        }
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::select('*');

        if ($search['q']) {
            $data = $data->where('name', 'iLIKE', "%{$search['q']}%")
                        ->orWhere('hospital_abbreviation', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            $data = $data->where('status', $search['status']);
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
{
    if ($request === false) {
        $request = request();
    }

    $request->validate([
        'name' => ['required'],
        'description' => ['required'],
        'address' => ['required'],
        'hospital_abbreviation' => ['required'],
        'hospital_phone' => ['required'],
        'hospital_cell' => ['required'],
        'logo' => ['required', 'mimes:jpeg,png,jpg,gif'],
        'project_logo' => ['nullable', 'mimes:jpeg,png,jpg,gif'],
    ]);

    $obj = new Hospital;
    $obj->name = $request->name;
    $obj->address = $request->address;
    $obj->description = $request->description;
    $obj->hospital_abbreviation = $request->hospital_abbreviation;
    $obj->hospital_phone = $request->hospital_phone;
    $obj->hospital_cell = $request->hospital_cell;
    $obj->status = 1;
    $obj->created_by = auth()->user()->id;

    // Handle logo upload before saving
    if ($request->hasFile('logo')) {
        $dir = self::LogoPath();
        $path = public_path() . '/' . $dir;

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        $extension = $request->file('logo')->getClientOriginalExtension();
        $ImageName = strtolower($dir . Str::random(8) . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension);
        $request->file('logo')->move(self::LogoPath(), $ImageName);
        $obj->logo = $ImageName;
    }

    // Handle project logo upload if present
    if ($request->hasFile('project_logo')) {
        $dir = self::ProjectLogoPath();
        $path = public_path() . '/' . $dir;

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        $extension = $request->file('project_logo')->getClientOriginalExtension();
        $ImageName = strtolower($dir . Str::random(8) . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension);
        $request->file('project_logo')->move(self::ProjectLogoPath(), $ImageName);
        $obj->project_logo = $ImageName;
    }

    // Save after handling all file uploads
    $obj->save();

    session()->flash('success', 'Hospital created successfully');
    return redirect()->route('hospitals.index');
}

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $obj = Hospital::find($request->id);
        $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'description' => ['required'],
            'hospital_abbreviation' => ['required'],
            'hospital_phone' => ['required'],
            'hospital_cell' => ['required'],
            'status' => ['required'],
            'logo' => ['nullable', 'mimes:jpeg,png,jpg,gif'],
            'project_logo' => ['nullable', 'mimes:jpeg,png,jpg,gif'],
        ]);

        $obj->name = $request->name;
        $obj->address = $request->address;
        $obj->description = $request->description;
        $obj->hospital_abbreviation = $request->hospital_abbreviation;
        $obj->hospital_phone = $request->hospital_phone;
        $obj->hospital_cell = $request->hospital_cell;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;

        // Handle logo upload/removal
        if ($request->hasFile('logo') || $request->logo_remove == 1) {
            $obj->UpdateLogo(false);
        }

        // Handle project logo upload/removal
        if ($request->hasFile('project_logo') || $request->project_logo_remove == 1) {
            $obj->UpdateProjectLogo(false);
        }

        $obj->save();

        session()->flash('success', 'Hospital updated successfully');
        return redirect()->route('hospitals.index');
    }

    public function deleteObj()
    {
        // Delete associated files
        if ($this->logo != '') {
            $logo_path = public_path() . '/' . $this->logo;
            if (File::exists($logo_path)) {
                File::delete($logo_path);
            }
        }

        if ($this->project_logo != '') {
            $project_logo_path = public_path() . '/' . $this->project_logo;
            if (File::exists($project_logo_path)) {
                File::delete($project_logo_path);
            }
        }

        $this->deleted_by = auth()->user()->id;
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Hospital has been deleted successfully',
        ]);
    }

    public static function getHospitalsCount()
    {
        return self::count();
    }
}
