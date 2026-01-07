<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;

class TestFcmController extends Controller
{
    public function send(Request $request, FirebaseService $firebase)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        return $firebase->sendToToken(
            $request->token,
            'Test Notification',
            'Hello from Laravel + FCM',
            [
                'type' => 'test'
            ]
        );
    }
}