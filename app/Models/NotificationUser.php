<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'notification_id',
        'notification_sender_id',
        'notification_receiver_id',
        'notification_title',
        'notification_message',
        'viewed_at',
        'is_read',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function sendNotification($receiverId, $notificationTemplate, $messageTemplate)
    {
        self::create([
            'notification_id' => $notificationTemplate->id,
            'notification_sender_id' => auth()->user()->id,
            'notification_receiver_id' => $receiverId,
            'notification_title' => $notificationTemplate->name,
            'notification_message' => $messageTemplate,
            'is_read' => false,
            'created_by' => auth()->user()->id
        ]);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'notification_sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'notification_receiver_id');
    }
}
