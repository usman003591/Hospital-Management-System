<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationUser;

class NotificationUserSeeder extends Seeder
{
    public function run(): void
    {
        NotificationUser::create([
            'notification_id' => 1,
            'notification_sender_id' => 1,
            'notification_receiver_id' => 1, 
            'notification_title' => 'Welcome!',
            'notification_message' => 'Your account has been created.',
            'created_by' => 1
        ]);

        NotificationUser::create([
            'notification_id' => 2,
            'notification_sender_id' => 1,
            'notification_receiver_id' => 1,
            'notification_title' => 'Reminder',
            'notification_message' => 'Your appointment is tomorrow at 10 AM.',
            'created_by' => 1
        ]);
         NotificationUser::create([
            'notification_id' => 3,
            'notification_sender_id' => 1,
            'notification_receiver_id' => 1,
            'notification_title' => 'notification',
            'notification_message' => 'Your appointment is tomorrow at 10 AM.',
            'created_by' => 1
        ]);
    }
}
