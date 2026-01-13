<?php

use App\Http\Controllers\Controller;
use App\Services\FcmService;
use Illuminate\Support\Facades\Auth;

class TestNotificationController extends Controller
{
    public function sendTest()
    {
        $user = Auth::user();
        $token = $user->fcmTokens()->first()->token;

        $response = FcmService::send(
            $token,
            'حجز جديد',
            'لديك حجز جديد في شقتك'
        );

        return response()->json([
            'message' => 'Notification sent',
            'fcm_response' => $response->body()
        ]);
    }
}
