<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPreferences;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->truncate();
        \DB::table('user_preferences')->truncate();
        // check if table users is empty

        if (User::count() == 0) {

            $user = User::create([
                'name' => 'Ali Shahbaz',
                'email' => 'alee.shahbazz@gmail.com',
                'password' =>  Hash::make('admin12345'),
                'role_id' => 1,
                'phone' => '03335994444',
                'status' => 1
            ]);

            $user_preference = new UserPreferences;
            $user_preference->user_id = $user->id;
            $user_preference->hospital_id = 1;
            $user_preference->theme = 'light';
            $user_preference->rtl_mode = 0;
            $user_preference->layout = 'dark_sidebar';
            $user_preference->system_language = 'english';
            $user_preference->data_view = 'list';
            $user_preference->created_by = $user->id;
            $user_preference->save();

            $user = User::create([
                'name' => 'Kaleem',
                'email' => 'kaleem@smartcityhospitals.com',
                'password' =>  Hash::make('admin12345'),
                'role_id' => 1,
                'phone' => '03335994444',
                'status' => 1
            ]);

            $user_preference = new UserPreferences;
            $user_preference->user_id = $user->id;
            $user_preference->hospital_id = 1;
            $user_preference->theme = 'light';
            $user_preference->rtl_mode = 0;
            $user_preference->layout = 'dark_sidebar';
            $user_preference->system_language = 'english';
            $user_preference->data_view = 'list';
            $user_preference->created_by = $user->id;
            $user_preference->save();

            $user = User::create([
                'name' => 'Ali',
                'email' => 'ali@smartcityhospitals.com',
                'password' =>  Hash::make('admin12345'),
                'role_id' => 1,
                'phone' => '03335994444',
                'status' => 1
            ]);

            $user_preference = new UserPreferences;
            $user_preference->user_id = $user->id;
            $user_preference->hospital_id = 1;
            $user_preference->theme = 'light';
            $user_preference->rtl_mode = 0;
            $user_preference->layout = 'dark_sidebar';
            $user_preference->system_language = 'english';
            $user_preference->data_view = 'list';
            $user_preference->created_by = $user->id;
            $user_preference->save();


            $user = User::create([
                'name' => 'junaid Ahmed',
                'email' => 'junahmed46@gmail.com',
                'password' =>  Hash::make('junaid'),
                'role_id' => 1,
                'phone' => '03335994444',
                'status' => 1
            ]);

            $user_preference = new UserPreferences;
            $user_preference->user_id = $user->id;
            $user_preference->hospital_id = 1;
            $user_preference->theme = 'light';
            $user_preference->rtl_mode = 0;
            $user_preference->layout = 'dark_sidebar';
            $user_preference->system_language = 'english';
            $user_preference->data_view = 'list';
            $user_preference->created_by = $user->id;
            $user_preference->save();

        }
    }
}
