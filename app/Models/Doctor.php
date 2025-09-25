<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Str;
use App\Models\UserPreferences;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'doctors';

    protected $fillable = ['doctor_name', 'department_id','password','doctor_specialization', 'qualification', 'email', 'doctor_address', 'doctor_image', 'created_by','opd_layout'];

    //Relationships
    public function cdDoctors()
    {
        return $this->hasMany(CdDoctor::class, 'doctor_id');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public static function getActiveDoctors()
    {
        return self::get();
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getUsersLoggedInHospitalDoctors () {

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $data = Doctor::join('users as user','user.id','doctors.user_id')
               ->join('departments as d', 'd.id', 'doctors.department_id')
               ->select([
                    'doctors.id as id',
                    'd.name as department_name',
                    'doctors.doctor_name as doctor_name',
               ])
               ->where('user.hospital_id',$hospital_id)
               ->get();

        return $data;
    }

    //Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }
    public static function getByUserId($id)
    {
        return self::where('user_id', $id)->first();
    }

    public static function getForSelect()
    {
        return self::leftjoin('departments as d', 'd.id', 'doctors.department_id')
            ->select([
                'd.name as department_name',
                'doctors.*',
            ])
            ->where('doctors.status', 1)->get();
    }

    public static function AvatarImage()
    {
        return 'src/media/doctors/';
    }

    public function UpdateImage($save = true)
    {
        $request = request();
        $dir = self::AvatarImage();
        $path = public_path() . '/' . $dir;
        $doctor_image = public_path() . '/' . $this->doctor_image;

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        if ($this->doctor_image != '' && File::exists($doctor_image)) {
            File::delete($doctor_image);
        }
        if ($request->image_remove == 1 && File::exists($doctor_image)) {
            File::delete($doctor_image);
            $this->doctor_image = '';
        } else {
            $extension = $request->file('doctor_image')->getClientOriginalExtension();
            $ImageName = strtolower($dir . Str::random(8) . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension);
            $request->file('doctor_image')->move(self::AvatarImage(), $ImageName);
            $this->doctor_image = $ImageName;
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
        $search['department'] = $request->has('department') ? $request->get('department') : false;

        $data = self::leftjoin('departments as d', 'd.id', 'doctors.department_id')->select(['d.name as department_name', 'doctors.*']);

        if ($search['q']) {
            $data = $data->where('doctors.doctor_name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('doctors.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('doctors.status', 0);
            }
        }

        if ($search['department']) {
            $data = $data->where('doctors.department_id', $search['department']);
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('doctors.created_at', 'desc')->paginate(10);

        return $rtn;
    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'doctor_name' => ['required'],
            // 'password' => ['required'],
            'department_id' => ['required'],
            'doctor_specialization' => ['required'],
            'qualification' => ['required'],
            'email' => ['required', 'email', 'max:100', Rule::unique('doctors', 'email')->whereNull('deleted_at')],
            'doctor_address' => ['required'],
            'doctor_image' => ['required', 'mimes:jpeg,png,jpg,gif'],
        ], [
            'doctor_name.required' => 'The doctor name is required',
            'department_id.required' => 'The department is required.',
            'doctor_specialization.required' => 'The doctor specialization is required.',
            'qualification.required' => 'The qualification is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'email.max' => 'The email must not exceed 100 characters.',
            'doctor_address.required' => 'The doctor address is required.',
            'doctor_image.required' => 'The doctor image is required.',
            'opd_layout' => ['required', 'in:modern,simple,advanced'],

        ]);

        $obj = new Doctor;
        $obj->doctor_name = $request->doctor_name;
        $obj->department_id = $request->department_id;
        $obj->doctor_specialization = $request->doctor_specialization;
        $obj->qualification = $request->qualification;
        // $obj->password = bcrypt($request->password);
        $obj->email = $request->email;
        $obj->doctor_address = $request->doctor_address;
        $obj->is_specialist = 0; // Handle is_specialist field
        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->opd_layout = $request->opd_layout;


        if ($request->has('doctor_image')) {
            $obj->UpdateImage();
        }
        $obj->save();

        session()->flash('success', 'Doctor created successfully');
        return Redirect::route('doctors.index');
    }

    public static function getDoctorsCount()
    {
        return self::count();
    }

    public function updateForm($request = false)
    {

        if ($request === false) {
            $request = request();
        }

        $obj = Doctor::find($request->id);
        $request->validate([
            'doctor_name' => ['required'],
            'department_id' => ['required'],
            'password' => ['nullable'],
            'doctor_specialization' => ['required'],
            'qualification' => ['required'],
            'email' => ['required', 'email', 'max:100', Rule::unique('doctors', 'email')->ignore($obj->id)->whereNull('deleted_at')],
            'doctor_address' => ['required'],
            'is_specialist' => ['required', 'boolean'],
            // 'doctor_image' => ['required','mimes:jpeg,png,jpg,gif'],
            'status' => ['required'],
        ], [
            'doctor_name.required' => 'The doctor name is required',
            'department_id.required' => 'The department is required.',
            'doctor_specialization.required' => 'The doctor specialization is required.',
            'qualification.required' => 'The qualification is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 100 characters.',
            'email.unique' => 'The email has already been taken.',
            'doctor_address.required' => 'The doctor address is required.',
            'doctor_image.required' => 'The doctor image is required.',
            'opd_layout' => ['required', 'in:modern,simple,advanced'],

        ]);

        $obj->doctor_name = $request->doctor_name;
        $obj->department_id = $request->department_id;
        $obj->doctor_specialization = $request->doctor_specialization;
        $obj->qualification = $request->qualification;
        $obj->email = $request->email;
        $obj->doctor_address = $request->doctor_address;
        $obj->is_specialist = $request->is_specialist;
        $obj->status = $request->status;
        $obj->updated_by = auth()->user()->id;
        $obj->opd_layout = $request->opd_layout;

        // if ($request->has('password')) {
        //     $obj->password = bcrypt($request->password);
        // }

        if ($request->has('doctor_image')) {
            $obj->UpdateImage();
        }
        $obj->update();

        session()->flash('success', 'Doctor updated successfully');
        return Redirect::route('doctors.index');
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();
        $user = User::where('id',$this->user_id)->first();

        if ($user) {
            $user->deleted_by = auth()->user()->id;
            $user->delete();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Doctor has been deleted successfully',
        ]);
    }

    public static function getHospitalDoctors($hospital_id)
    {
        return self::join('users', 'users.id', '=', 'doctors.user_id')
            ->leftjoin('departments as d', 'd.id', '=', 'doctors.department_id')
            ->where('users.hospital_id', $hospital_id)
            ->where('users.user_type', 'Doctor')
            ->where('users.status', 1)
            ->where('doctors.status', 1)
            ->select([
                'doctors.id',
                'doctors.doctor_name',
                'doctors.email',
                'doctors.doctor_specialization',
                'doctors.qualification',
                'doctors.department_id',
                'users.name as name', // This is what your JS is looking for
                'users.email as user_email',
                'd.name as department_name'
            ])
            ->get();
    }
}
