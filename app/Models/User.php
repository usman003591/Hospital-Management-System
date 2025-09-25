<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Doctor;
use Illuminate\Support\Str;
use App\Models\UserPreferences;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function AvatarImage()
    {
        return 'src/media/users/';
    }

    public static function getForSelectData()
    {
        return self::pluck('name', 'id')->toArray();
    }

    public static function getById($id)
    {
        return self::find($id);
    }
    public static function getForSelect()
    {
        return self::where('status', 1)->get();
    }

    public function doctors(){
        return $this->hasOne(Doctor::class, 'user_id');
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['status'] = $request->has('status') ? $request->get('status') : false;

        $data = self::leftjoin('roles as r', 'r.id', 'users.role_id')->select(['r.name as role_name', 'users.*']);

        if ($search['q']) {
            $data = $data->where('users.name', 'iLIKE', "%{$search['q']}%");
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('users.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('users.status', 0);
            }
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderby('users.created_at', 'desc')->paginate(10);

        return $rtn;
    }


    public static function getHospitalDoctors($hospital_id)
    {
        return self::where('user_type', 'Doctor')
            ->where('status', 1)
            ->where('hospital_id', $hospital_id)
            ->get();
    }

    public static function getAssignedRoleusers($role_id)
    {

        $users = User::select('*')
            ->where('users.role_id', $role_id)
            ->where('users.status', 1)
            ->paginate(10);

        return $users;
    }
    public function addForm($request = false)
    {

        if ($request === false) {
            $request = request();
        }

        $valid = $this->formValidation($request->all(), true);

        if ($valid === true) {

            $obj = User::find(auth()->user()->id);
            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->phone = $request->phone;
            if ($request->has('image')) {
                $obj->UpdateImage();
            }
            $obj->save();

            session()->flash('success', 'Profile updated successfully');
            return Redirect::route('profile.settings');

        } else {
            return $valid;
        }
    }

    public function updateForm($request = false): RedirectResponse
    {

        if ($request === false) {
            $request = request();
        }

        if ($request->user_type === 'Doctor') {
            $doctorData = Doctor::where('user_id', auth()->id())->first();
            if ($doctorData) {
                $request->merge([
                    'department_id' => $doctorData->department_id ?? null,
                    'doctor_specialization' => $doctorData->doctor_specialization ?? null,
                    'qualification' => $doctorData->qualification ?? null,
                    'doctor_address' => $doctorData->doctor_address ?? null,
                ]);
            }
        }

        $obj = User::find($request->id);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'digits_between:10,11'],
            'role_id' => ['required', 'string'],
            'status' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique(User::class, 'email')->ignore($obj->id)->whereNull('deleted_at')
            ],
            'password' => ['nullable', 'string', Password::min(8)->letters()->numbers()->mixedCase()->symbols()->max(120)],
            'hospital_id' => ['required', 'integer'],
            'user_type' => ['required', Rule::in('Employee', 'Doctor')],
            'department_id' => ['required_if:user_type,Doctor', 'max:50'],
            'doctor_specialization' => ['required_if:user_type,Doctor'],
            'qualification' => ['required_if:user_type,Doctor'],
            'doctor_address' => ['required_if:user_type,Doctor'],
        ], [
            'role_id.required' => 'The role is required',
            'hospital_id.required' => 'The hospital is required',
            'password.required' => 'The password is required',
            'password.min' => 'The password must be at least 8 characters long',
            'password.max' => 'The password must not exceed 120 characters',
            'password.symbols' => 'The password must contain at least one special character',
            'role_id.string' => 'The role must have a string value',
            'hospital_id.integer' => 'The hospital must have an integer value',
            'phone.digits_between' => 'The phone number should be between 10 and 11',
            'phone.required' => 'The phone number is required',
            'phone.string' => 'The phone number must have a string value',
            'name.required' => 'The name is required',
            'name.string' => 'The name must have a string value',
            'name.max' => 'The name should not be more than 50 characters',
            'email.required' => 'The email is required',
            'email.email' => 'The email must be a valid email address',
            'email.string' => 'The email must have a string value',
            'email.max' => 'The email should not be more than 100 characters',
            'email.unique' => 'The email has already been taken',
            'user_type.required' => 'User type is required',
            'department_id.required' => 'Department is required',
            'doctor_specialization.required' => 'Doctor specialization is required',
            'doctor_specialization.max' => 'Doctor specialization should not be more than 50 characters',
            'qualification.required' => 'Doctor qualification is required',
            'qualification.max' => 'Doctor qualification should not be more than 50 characters',
            'doctor_address.required' => 'Doctor address is required',
            'doctor_address.max' => 'Doctor address should not be more than 200 characters',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'There were validation errors!');
        }

        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->phone = $request->phone;
        $obj->role_id = $request->role_id;

        $password = $request->password;
        if (!empty($password) && $password != '') {
            $obj->password = Hash::make($password);
        }

        if ($request->has('image')) {
            $obj->UpdateImage();
        }
        $obj->user_type = $request->user_type;
        if ($request->user_type === 'Doctor') {
            $doctor = Doctor::where('user_id', $obj->id)->first();

            if ($doctor) {
                $doctor->doctor_name = $obj->name;
                $doctor->email = $obj->email;
                $doctor->doctor_image = $obj->image;
                $doctor->department_id = $request->department_id;
                $doctor->doctor_specialization = $request->doctor_specialization;
                $doctor->qualification = $request->qualification;
                $doctor->doctor_address = $request->doctor_address;
                $doctor->status = $request->status;
                $doctor->updated_by = auth()->user()->id ?? null;
                $doctor->save();
            } else {
                $doctor = new Doctor();
                $doctor->user_id = $obj->id;
                $doctor->doctor_name = $obj->name;
                $doctor->email = $obj->email;
                $doctor->doctor_image = $obj->image;
                $doctor->department_id = $request->department_id;
                $doctor->doctor_specialization = $request->doctor_specialization;
                $doctor->qualification = $request->qualification;
                $doctor->doctor_address = $request->doctor_address;
                $doctor->status = $request->status;
                $doctor->created_by = auth()->user()->id ?? null;
                $doctor->save();
            }
        }
        $obj->updated_by = auth()->user()->id;
        $obj->status = $request->status;
        $obj->update();

        $hospital_id = $request->hospital_id;

        if ($obj) {
            $preference = UserPreferences::UpdateUserPreferences($obj->id, $hospital_id);
        }

        session()->flash('success', 'User updated successfully');
        return Redirect::route('users.index');
    }

    public function createForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        if ($request->user_type === 'Doctor') {
            $doctorData = Doctor::where('user_id', auth()->id())->first();

            if ($doctorData) {
                $request->merge([
                    'department_id' => $doctorData->department_id ?? null,
                    'doctor_specialization' => $doctorData->doctor_specialization ?? null,
                    'qualification' => $doctorData->qualification ?? null,
                    'doctor_address' => $doctorData->doctor_address ?? null,
                ]);
            }
        }

        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'digits_between:10,11'],
            'role_id' => ['required', 'string'],
            'password' => ['required', 'string', Password::min(8)->letters()->numbers()->mixedCase()->symbols()->max(120)],
            'email' => [
                'required',
                'email',
                'string',
                'max:50',
                Rule::unique(User::class, 'email')->whereNull('deleted_at'),
                Rule::unique('doctors', 'email')->whereNull('deleted_at'),
            ],
            'image' => ['mimes:jpeg,jpg,png,gif', 'required', 'max:10000'],
            'hospital_id' => ['required', 'integer'],
            'user_type' => ['required', Rule::in('Employee', 'Doctor')],
        ];

        // Add doctor-specific rules only if user_type is Doctor
        if ($request->user_type === 'Doctor') {
            $rules = array_merge($rules, [
                'department_id' => ['required'],
                'doctor_specialization' => ['required', 'string', 'max:50'],
                'qualification' => ['required', 'string', 'max:50'],
                'doctor_address' => ['required', 'string', 'max:200'],
            ]);
        }

        $request->validate($rules, [
            'role_id.required' => 'The role is required',
            'hospital_id.required' => 'The hospital is required',
            'password.required' => 'The password is required',
            'password.min' => 'The password must be at least 8 characters long',
            'password.max' => 'The password must not exceed 120 characters',
            'password.symbols' => 'The password must contain at least one special character',
            'role_id.string' => 'The role must have a string value',
            'hospital_id.integer' => 'The hospital must have an integer value',
            'phone.digits_between' => 'The phone number should be between 10 and 11',
            'phone.required' => 'The phone number is required',
            'phone.string' => 'The phone number must have a string value',
            'name.required' => 'The name is required',
            'image.required' => 'Image is required',
            'name.string' => 'The name must have a string value',
            'name.max' => 'The name should not be more than 50 characters',
            'email.required' => 'The email is required',
            'email.email' => 'The email must be a valid email address',
            'email.string' => 'The email must have a string value',
            'email.max' => 'The email should not be more than 100 characters',
            'email.unique' => 'The email has already been taken',
            'user_type.required' => 'User type is required',
            'department_id.required' => 'Department is required',
            'doctor_specialization.required' => 'Doctor specialization is required',
            'doctor_specialization.max' => 'Doctor specialization should not be more than 50 characters',
            'qualification.required' => 'Doctor qualification is required',
            'qualification.max' => 'Doctor qualification should not be more than 50 characters',
            'doctor_address.required' => 'Doctor address is required',
            'doctor_address.max' => 'Doctor address should not be more than 200 characters',
        ]);

        // Create user
        $obj = new User;
        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->phone = $request->phone;
        $obj->role_id = $request->role_id;
        $obj->password = bcrypt($request->password);
        $obj->hospital_id = $request->hospital_id;
        $obj->user_type = $request->user_type;

        if ($request->has('image')) {
            $obj->UpdateImage();
        }

        $obj->status = 1;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        // Create doctor record if Doctor
        if ($request->user_type === 'Doctor') {
            $doctor = new Doctor();
            $doctor->doctor_name = $obj->name;
            $doctor->email = $obj->email;
            $doctor->doctor_image = $obj->image;
            $doctor->department_id = $request->department_id;
            $doctor->doctor_specialization = $request->doctor_specialization;
            $doctor->qualification = $request->qualification;
            $doctor->doctor_address = $request->doctor_address;
            $doctor->user_id = $obj->id;
            $doctor->status = 1;
            $doctor->created_by = auth()->user()->id ?? null;
            $doctor->save();
        }

        // Set default preferences
        $hospital_id = $request->hospital_id;

        if ($obj) {
            UserPreferences::createUserPreferences($obj->id, $hospital_id);
        }

        session()->flash('success', 'User created successfully');
        return Redirect::route('users.index');
    }


    public function formValidation($requestAll, $skipped = true, $id = false)
    {
        if ($id === false) {
            $validationArray = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'digits_between:10,11'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->user()->id)->whereNull('deleted_at')],
            ];
        } elseif ($id !== false) {
            $validationArray = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'digits_between:10,11'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->user()->id)->whereNull('deleted_at')],
            ];
        }

        if ($skipped !== true) {
            if (is_array($skipped)) {
                foreach ($skipped as $temp) {
                    unset($validationArray[$temp]);
                }
            } else {
                unset($validationArray[$skipped]);
            }
        }

        $v = Validator::make(
            $requestAll,
            $validationArray,
            [
                'name.required' => 'Please Provide name',
                'email.required' => 'Email is required',
                'email.email' => 'Email must be valid',
                'phone.required' => 'Phone is required',
                'phone.digits_between' => 'Phone must be between 10 and 11 digits.

                ',
            ]
        );

        if ($v->fails()) {
            return back()->withErrors($v->getMessageBag()->toArray());
        } else {
            return true;
        }
    }

    public function UpdateImage($save = true)
    {
        $request = request();
        $dir = self::AvatarImage();
        $path = public_path() . '/' . $dir;
        $image = public_path() . '/' . $this->image;

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        if ($this->image != '' && File::exists($image)) {
            File::delete($image);
        }
        if ($request->image_remove == 1 && File::exists($image)) {
            File::delete($image);
            $this->image = '';
        } else {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ImageName = strtolower($dir . Str::random(8) . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension);
            $request->file('image')->move(self::AvatarImage(), $ImageName);
            $this->image = $ImageName;
        }

        if ($save) {
            $this->save();
        }
    }

    public static function getAllUsersForChat($search = false)
    {

        $loggedInUser = auth()->user()->id;
        $query = User::query();

        if ($search) {
            $query->where('users.name', 'ilike', "%{$search}%")
                ->orWhere('users.email', 'ilike', "%{$search}%");
        }

        $fetchedUsers = $query->where('id', '!=', $loggedInUser)
            ->select([
                'id',
                'name',
                'email',
                'phone',
                'image'
            ])
            ->where('status', 1)
            ->get();

        if (isset($fetchedUsers)) {
            foreach ($fetchedUsers as $user) {
                $user->complete_image_path = url($user->image);
            }
        }

        $users = $fetchedUsers;
        return isset($users) ? $users : null;

    }

    public static function getUserData($id)
    {
        $user = self::where('id', $id)->where('status', 1)->first();
        if ($user) {
            return $user;
        }
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->delete();

        if ($this->user_type == 'doctor') {
            $doctor = Doctor::where('user_id',$this->id)->first();
            if ($doctor) {
               $doctor->deleted_by = auth()->user()->id;
               $doctor->delete();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'User has been deleted successfully',
        ]);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
