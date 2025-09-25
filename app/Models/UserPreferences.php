<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Exception;

class UserPreferences extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'theme', 'rtl_mode', 'layout', 'system_language', 'data_view','hospital_id'];

    public static function createUserPreferences($user_id,$hospital_id)
    {
        $user_preference = new UserPreferences;
        $user_preference->user_id = $user_id;
        $user_preference->hospital_id = $hospital_id;
        $user_preference->theme = 'light';
        $user_preference->rtl_mode = 0;
        $user_preference->layout = 'dark_sidebar';
        $user_preference->system_language = 'english';
        $user_preference->data_view = 'list';
        $user_preference->created_by = auth()->user()->id;
        $user_preference->save();

        return $user_preference;
    }

    public static function UpdateUserPreferences($user_id,$hospital_id) {

        $preference = UserPreferences::where('user_id',$user_id)->first();

        if ($preference) {

            $preference->hospital_id = $hospital_id;
            $preference->update();

        } else {

            $matchThese = ['user_id'=>$user_id,'hospital_id'=>intval($hospital_id)];
            $preference = UserPreferences::updateOrCreate($matchThese,[
                'layout'=>'dark_sidebar',
                'system_language'=>'english',
                'data_view'=>'list',
                'updated_by'=> auth()->user()->id,
            ]);
        }

        return $preference;

    }

    public static function getPreferences()
    {

        $preferences = self::all(['user_id', 'theme', 'rtl_mode', 'layout', 'system_language', 'data_view','hospital_id'])->where('user_id', auth()->user()->id);
        $mPreferences = [];

        foreach ($preferences as $se) {
            $mPreferences['preference']['theme'] = $se->theme;
            $mPreferences['preference']['rtl_mode'] = $se->rtl_mode;
            $mPreferences['preference']['layout'] = $se->layout;
            $mPreferences['preference']['system_language'] = $se->system_language;
            $mPreferences['preference']['data_view'] = $se->data_view;
            $mPreferences['preference']['hospital_id'] = $se->hospital_id;

        }

        return $mPreferences;
    }


    public static function getPreferencesOfSpecificUser($user_id)
    {

        $preferences = self::all(['user_id', 'theme', 'rtl_mode', 'layout', 'system_language', 'data_view','hospital_id'])->where('user_id', $user_id);
        $mPreferences = [];

        foreach ($preferences as $se) {
            $mPreferences['preference']['theme'] = $se->theme;
            $mPreferences['preference']['rtl_mode'] = $se->rtl_mode;
            $mPreferences['preference']['layout'] = $se->layout;
            $mPreferences['preference']['system_language'] = $se->system_language;
            $mPreferences['preference']['data_view'] = $se->data_view;
            $mPreferences['preference']['hospital_id'] = $se->hospital_id;

        }

        return $mPreferences;
    }

    public function updatePreferences($request = false)
    {

        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'theme' => ['required', 'string', 'max:255'],
            'hospital_id' => ['required', 'string'],
        ]);

        try {

            $user_id = auth()->user()->id;
            $preference = UserPreferences::where('user_id',$user_id)->first();
            $preference->theme = $request->theme;
            $preference->hospital_id = $request->hospital_id;
            $preference->layout = 'dark_sidebar';
            $preference->system_language = 'english';
            $preference->data_view = 'list';
            $preference->created_by = $user_id;
            $preference->update();

            $message = 'User Preference updated successfully';
            return response()->json([
                'status' => 200,
                'message' => $message,
            ]);

        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json([
                'status' => 400,
                'message' => $message
            ]);
        }

    }
}
