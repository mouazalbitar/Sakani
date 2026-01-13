<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class TestFcmNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;

    public function __construct($title = 'Test Notification', $body = 'This is a test message')
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['fcm']; // نستخدم قناة FCM
    }

    /**
     * Send notification via FCM
     */
    public function toFcm($notifiable)
    {
        $serverKey = env('FIREBASE_SERVER_KEY'); // ضع هنا مفتاح FCM Server Key

        // جلب التوكن المخزن للمستخدم
        $tokens = $notifiable->fcmTokens()->pluck('token')->toArray();

        foreach ($tokens as $token) {
            Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $token,
                'notification' => [
                    'title' => $this->title,
                    'body' => $this->body,
                ],
            ]);
        }
    }
}
